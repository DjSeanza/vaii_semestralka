<?php

namespace App\Controllers;

use App\Config\Configuration;
use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Comment;
use App\Models\Video;
use public\toast\Errors;
use public\toast\Successes;
use public\uploadFiles\FileDirectory;
use public\uploadFiles\FileType;
use public\uploadFiles\FileUpload;

class StudioController extends AControllerBase
{

    public function index(): Response
    {
        $query = $this->request()->getServer()['QUERY_STRING'];

        parse_str($query, $params);
        unset($params['c']);
        $query = http_build_query($params);
        return $this->redirect("?c=studio&a=listContent&" . $query);
    }

    /**
     * @throws \Exception
     */
    public function listContent(): Response {
        $errorId = $this->request()->getValue("e");

        if ($errorId == Errors::USER_NO_CONTENT) {
            return $this->html(viewName: "list.content");
        }

        /** @var \App\Core\IAuthenticator $auth */
        $auth = new(Configuration::AUTH_CLASS);
        $videos = Video::getAll('author = ?', [$auth->getLoggedUserId()]);

        if ($videos) {
            return $this->html(["videos" => $videos], viewName: "list.content");
        }

        return $this->redirect("?c=studio&a=listContent&e=" . Errors::USER_NO_CONTENT->value);
    }

    /**
     * @throws \Exception
     */
    public function formContent(): Response {
        $content_id = $this->request()->getValue("cid");
        if (isset($content_id) && $content_id) {
            $video = Video::getOne($content_id);
            return $this->html(["video" => $video], "form.content");
        }

        return $this->html(viewName: "form.content");
    }

    /**
     * @throws \Exception
     */
    public function storeContent(): Response {
        $content_id = $this->request()->getValue("cid");
        $data = $this->app->getRequest()->getPost();
        $files = $this->request()->getFiles();
        $content = ( $content_id ? Video::getOne($content_id) : new Video());

        if (isset($data['title']) && isset($data['description']) && isset($data['category'])) {
            if ($content_id == null) {
                $content->setAttributes($data['title'], $data['description'], $data['category'], $data['uid'], date('Y-m-d H:i:s'), 0);
            } else {
                $content->setAttributes($data['title'], $data['description'], $data['category'], $data['uid'], $content->getPostDate());
            }

            $areFilesUploaded = null;
            if ($files['thumbnail']['name'] && $files['content']['name']) {
                $fileUpload = new FileUpload($files,
                    FileDirectory::THUMBNAIL_WITH_CONTENT,
                    array(FileType::THUMBNAIL, FileType::VIDEO));
                $areFilesUploaded = $fileUpload->uploadFile();
            }

            if ($areFilesUploaded) {
                if ($areFilesUploaded instanceof Errors) {
                    return $this->redirect('?c=studio&e=' . $areFilesUploaded->value);
                } else {
                    $content->setThumbnail($areFilesUploaded[0]);
                    $content->setVideo($areFilesUploaded[1]);
                }
            } else {
                $content->setThumbnail($content->getThumbnail());
                $content->setVideo($content->getVideo());
            }
        } else {
            return $this->redirect('?c=studio&e=' . Errors::UNEXPECTED_ERROR->value);
        }

        $content->save();
        return $this->redirect('?c=studio&s=' . Successes::CONTENT_ADDED->value);
    }

    /**
     * @throws \Exception
     */
    public function deleteContent(): Response {
        $content_id = $this->request()->getValue("cid");

        if (!$content_id) {
            return $this->redirect('?c=studio&e=' . Errors::VIDEO_NOT_FOUND->value);
        }

        $content = Video::getOne($content_id);
        $comments = Comment::getAll('video = ? && reply_to is null', [$content_id]);

        if ($comments) {
            foreach ($comments as $comment) {
                $replies = $comment->getReplies();
                if ($replies) {
                    foreach ($replies as $reply) {
                        $reply->delete();
                    }
                }
                $comment->delete();
            }
        }

        if ($content) {
            unlink($content->getThumbnail());
            unlink($content->getVideo());
            rmdir(dirname($content->getThumbnail()));
            $content->delete();
        }

        return $this->redirect("?c=studio&s=" . Successes::CONTENT_DELETED->value);
    }
}