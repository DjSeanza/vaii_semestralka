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

        $commentsForVideo = Comment::getAll("video = ? && reply_to is null", [$videoId]);

        return $this->html(["video" => $video, "comments" => $commentsForVideo]);
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
            return $this->redirect("?c=content&a=content&e=" . Errors::COMMENT_DETAILS_NOT_FOUND->value . "&v=" . $video->getId());
        } else if ($video == null) {
            return $this->redirect("?c=content&a=content&e=" . Errors::VIDEO_NOT_FOUND->value . "&v=" . $video->getId());
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
            return $this->json(["commentId" => $newCommentId, "cookieName" => $auth->getLoggedUserName() ,"name" => $username, "comment" => $comment]);
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
            return $this->redirect('?c=content&e=' . Errors::VIDEO_NOT_FOUND->value);
        } else if ($commentId == null) {
            return $this->redirect('?c=home&e=' . Errors::COMMENT_NOT_FOUND->value);
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
            return $this->redirect('?c=content&a=content&v=' . $videoId . 'e=' . Errors::COMMENT_NOT_FOUND->value);
        }

        return $this->json(["comment" => $commentToDelete]);
    }

    /**
     * @throws \Exception
     */
    private function getLatestComment(): int {
        $latestComment = Connection::connect()->prepare("SELECT * FROM comments ORDER BY id DESC LIMIT 1");
        $latestComment->execute([]);
        return $latestComment->fetch()['id'];
    }
}