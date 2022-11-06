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
        $videoId = $this->request()->getValue('v');

//        @TODO vymysliet a dorobit errors
        if ($videoId == null || $errorId == Errors::VIDEO_NOT_FOUND->value) {
            return $this->html(["error" => "Video not found."]);
        }

        $video = Video::getOne($videoId);

        if (!isset($video)) {
            return $this->html(["error" => "Video not found."]);
        }

        $commentsForVideo = Comment::getAll("video = ?", [$videoId]);

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

        if ($author == null || $text == null || $video == null) {
            // TODO dorobit ak sa nenajde
            return $this->redirect("?c=content&a=content&v=" . $video->getId());
        }

        if ($comment->getId() == null) {
            $comment->setAtributes($author, $video->getId(), date('Y-m-d H:i:s'), null, $text);
        } else {
            $comment->setAtributes($author, $video->getId(), $comment->getPostTime(), date('Y-m-d H:i:s'), $text);
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
            return $this->redirect('?c=content&e=' . Errors::VIDEO_NOT_FOUND->value);
        } else if ($commentId == null) {
            return $this->redirect('?c=home&e=' . Errors::COMMENT_NOT_FOUND->value);
        }
        
        $commentToDelete = Comment::getOne($commentId);

        if ($commentToDelete) {
            $commentToDelete->delete();
        } else {
//            @TODO dorobit errors
            return $this->redirect('?c=content&a=content&v=' . $videoId . 'e=' . Errors::COMMENT_NOT_FOUND->value);
        }

        return $this->redirect('?c=content&a=content&v=' . $videoId);
    }

    /**
     * @throws \Exception
     */
    public function deleteReply() {
        $videoId = $this->request()->getValue('v');
        $replyId = $this->request()->getValue('reply');

        if ($videoId == null) {
            return $this->redirect('?c=content&e=' . Errors::VIDEO_NOT_FOUND->value);
        } else if ($replyId == null) {
            return $this->redirect('?c=home&e=' . Errors::COMMENT_NOT_FOUND->value);
        }

        $replyToDelete = Reply::getOne($replyId);

        if ($replyToDelete) {
            $replyToDelete->delete();
        } else {
//            @TODO dorobit errors
            return $this->redirect('?c=content&a=content&v=' . $videoId . 'e=' . Errors::COMMENT_NOT_FOUND->value);
        }

        return $this->redirect('?c=content&a=content&v=' . $videoId);
    }
}