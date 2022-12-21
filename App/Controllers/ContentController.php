<?php
namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Comment;
use App\Models\Reply;
use App\Models\Video;
use public\errors\Errors;

class ContentController extends AControllerBase
{
    public function index(): Response
    {
        return $this->redirect("?c=content&a=content");
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
        return $this->redirect("?c=content&a=content&v=" . $video->getId());
    }

    /**
     * @throws \Exception
     */
    public function deleteComment(): Response {
        $videoId = $this->request()->getValue('v');
        $commentId = $this->request()->getValue('comment');

        if ($videoId == null) {
//            @TODO errory nejako prerobit
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
//            @TODO dorobit errors
            return $this->redirect('?c=content&a=content&v=' . $videoId . 'e=' . Errors::COMMENT_NOT_FOUND->value);
        }

        return $this->redirect('?c=content&a=content&v=' . $videoId);
    }
}