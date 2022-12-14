<?php
namespace App\Controllers;

use App\Config\Configuration;
use App\Core\AControllerBase;
use App\Core\DB\Connection;
use App\Core\IAuthenticator;
use App\Core\Responses\Response;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Reply;
use App\Models\User;
use App\Models\Video;
use public\toast\Errors;

class ContentController extends AControllerBase
{
    public function index(): Response
    {
        return $this->redirect("?c=content&a=content");
    }

    /**
     * @throws \Exception
     */
    public function listContent(): Response {
        $categoryId = $this->request()->getValue("cat");
        $userId = $this->request()->getValue("uid");
        $error = $this->request()->getValue("e");

        if ($error) {
            return $this->html(viewName: "listed.content");
        }

        if ($categoryId) {
            $category = Category::getOne($categoryId);
            if (!$category) {
                return $this->redirect("?c=content&a=listContent&e=" . Errors::CATEGORY_NOT_FOUND->value);
            }

            $videos = Video::getAll('category = ?', [$categoryId]);
            if (!$videos) {
                return $this->redirect("?c=content&a=listContent&e=" . Errors::VIDEO_NOT_FOUND->value);
            }

            return $this->html(["name" => $category->getCategoryName(),
                                "videos" => $videos], viewName: "listed.content");
        } else if ($userId) {
            $user = User::getOne($userId);
            if (!$user) {
                return $this->redirect("?c=content&a=listContent&e=" . Errors::USER_NO_CONTENT->value);
            }

            $videos = Video::getAll('author = ?', [$userId]);
            if (!$videos) {
                return $this->redirect("?c=content&a=listContent&e=" . Errors::VIDEO_NOT_FOUND->value);
            }

            return $this->html(["name" => $videos[0]->getAuthorName(),
                "videos" => $videos], viewName: "listed.content");
        }

        return $this->html(viewName: "listed.content");
    }

    /**
     * @throws \Exception
     */
    public function content(): Response {
        $errorId = $this->request()->getValue('e');
// TODO ak vratim cisto html, tak vrati video not found
        if (isset($errorId)) {
            return $this->html();
        }

        $videoId = $this->request()->getValue('v');

        if ($videoId == null || $errorId == Errors::VIDEO_NOT_FOUND->value) {
            return $this->redirect("?c=content&a=content&e=" . Errors::VIDEO_NOT_FOUND->value);
        }

        $video = Video::getOne($videoId);

        if (!isset($video)) {
            return $this->redirect("?c=content&a=content&e=" . Errors::VIDEO_NOT_FOUND->value);
        }

        $videoViews = $video->getViews();
        $video->setViews($videoViews + 1);
        $video->save();

        $commentsForVideo = Comment::getAll("video = ? && reply_to is null", [$videoId]);
        $authorVideos = $this->getAuthorLastVideos($video->getAuthor());

        $query = Connection::connect()->prepare("SELECT * FROM videos WHERE author != ? LIMIT 5");
        $query->execute([$video->getAuthor()]);
        $generatedVideos = Video::fetchAllVideos($query);

        return $this->html(["video" => $video, "comments" => $commentsForVideo, "authorVideos" => $authorVideos, "generatedVideos" => $generatedVideos]);
    }

    public function listedContent(): Response {
        return $this->html(viewName: 'listed.content');
    }

    /**
     * @throws \Exception
     */
    public function storeComment(): Response {
        $commentId = $this->request()->getValue('comment');
        $videoId = $this->request()->getValue('v');

        // TODO ze vraj nejako osetrit

        $comment = ( $commentId ? Comment::getOne($commentId) : new Comment());
        $video = ( $videoId ? Video::getOne($videoId) : null);
        $author = $this->request()->getValue('author');
        $text = $this->request()->getValue('video-comment');
        $replyTo = $this->request()->getValue("reply-to");

        if ($author == null || $text == null) {
            return $this->json(["e" => Errors::COMMENT_DETAILS_NOT_FOUND->value]);
        } else if ($video == null) {
            return $this->json(["e" => Errors::VIDEO_NOT_FOUND->value]);
        }

        // https://www.php.net/manual/en/function.rtrim.php
        $text = rtrim($text, " \n\r\t\v\x00"); // remove last empty line from string

        if ($commentId == null) {
            if ($replyTo == null) {
                $comment->setAtributes($author, $video->getId(), date('Y-m-d H:i:s'), $text);
            } else {
                $comment->setAtributes($author, $video->getId(), date('Y-m-d H:i:s'), $text, null, $replyTo);
            }
        } else {
            if ($replyTo == null) {
                $comment->setAtributes($author, $video->getId(), $comment->getPostTime(), $text, date('Y-m-d H:i:s'));
            } else {
                $comment->setAtributes($author, $video->getId(), $comment->getPostTime(), $text, date('Y-m-d H:i:s'), $replyTo);
            }
        }

        $comment->save();
        $username = User::getOne($author)->getLogin();
        /** @var IAuthenticator $auth */
        $auth = new(Configuration::AUTH_CLASS);
        $newCommentId = null;
        if (!$commentId) {
            $newCommentId = $this->getLatestComment();
            return $this->json(["commentId" => $newCommentId, "cookieName" => $auth->getLoggedUserName(), "cookieId" => $auth->getLoggedUserId(),"name" => $username, "comment" => $comment]);
        }

        return $this->json(["cookieName" => $auth->getLoggedUserName() ,"name" => $username, "comment" => $comment]);
    }

    /**
     * @throws \Exception
     */
    public function deleteComment(): Response {
        $videoId = $this->request()->getValue('v');
        $commentId = $this->request()->getValue('comment');

        if ($videoId == null) {
            return $this->json(["e" => Errors::VIDEO_NOT_FOUND->value]);
        } else if ($commentId == null) {
            return $this->json(["e" => Errors::COMMENT_NOT_FOUND->value]);
        }
        
        $commentToDelete = Comment::getOne($commentId);

        if ($commentToDelete) {
            $replies = $commentToDelete->getReplies();
            if ($replies) {
                foreach ($replies as $reply) {
                    $reply->delete();
                }
            }

            $commentToDelete->delete();

        } else {
            return $this->json(["e" => Errors::COMMENT_NOT_FOUND->value, "v" => $videoId, "a" => "content"]);
        }

        return $this->json(["comment" => $commentToDelete]);
    }

    /**
     * @throws \Exception
     */
    public function getNotAuthorVideos(): Response|null {
        $offset = $this->request()->getValue("offset");
        $videoId = $this->request()->getValue("v");
        $video = Video::getOne($videoId);

        if (!$video) {
            return null;
        }

        $query = Connection::connect()->prepare("SELECT * FROM videos WHERE author != ? LIMIT 5 OFFSET " . $offset);
        $query->execute([$video->getAuthor()]);
        $generatedVideos = Video::fetchAllVideos($query);

        for ($i = 0; $i < count($generatedVideos); $i++) {
            $generatedVideos[$i] = array("author" => $generatedVideos[$i]->getAuthorName(), "video" => $generatedVideos[$i]);
        }

        return $this->json($generatedVideos);
    }

    /**
     * @throws \Exception
     */
    private function getLatestComment(): int {
        $latestComment = Connection::connect()->prepare("SELECT * FROM comments ORDER BY id DESC LIMIT 1");
        $latestComment->execute([]);
        return $latestComment->fetch()['id'];
    }

    /**
     * @throws \Exception
     */
    private function getAuthorLastVideos(int $authorId): array {
        $queryLatest = Connection::connect()->prepare("SELECT * FROM videos WHERE author = ? ORDER BY id DESC LIMIT 5");
        $queryLatest->execute([$authorId]);
        return Video::fetchAllVideos($queryLatest);
    }
}