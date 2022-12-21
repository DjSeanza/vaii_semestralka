<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Video;
use public\errors\Errors;
use public\uploadFiles\FileDirectory;
use public\uploadFiles\FileType;
use public\uploadFiles\FileUpload;

class StudioController extends AControllerBase
{

    public function index(): Response
    {
        return $this->redirect("?c=studio&a=listContent");
    }

    public function listContent(): Response {
        return $this->html(viewName: "list.content");
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
        $content = ( $content_id ? Video::getOne($content_id) : new Video());

        if (isset($data['title']) && isset($data['description']) && isset($data['category'])) {
            if ($content_id == null) {
                $content->setAttributes($data['title'], $data['description'], $data['category'], $data['uid'], date('Y-m-d H:i:s'), 0);
            } else {
                $content->setAttributes($data['title'], $data['description'], $data['category'], $data['uid'], $content->getPostDate());
            }

            $areFilesUploaded = null;
            if (array_key_exists('name', $_FILES)) {
                $fileUpload = new FileUpload($_FILES,
                    FileDirectory::THUMBNAIL_WITH_CONTENT,
                    array(FileType::THUMBNAIL, FileType::VIDEO));
                $areFilesUploaded = $fileUpload->uploadFile();
            }

            if ($areFilesUploaded) {
                if ($areFilesUploaded instanceof Errors) {
                    return $this->redirect('?c=studio&a=listContent&e=' . $areFilesUploaded->value);
                } else {
                    $content->setThumbnail($areFilesUploaded[0]);
                    $content->setVideo($areFilesUploaded[1]);
                }
            } else {
                $content->setThumbnail($content->getThumbnail());
                $content->setVideo($content->getVideo());
            }
        } else {
            return $this->redirect('?c=studio&a=listContent&e=' . Errors::UNEXPECTED_ERROR->value);
        }

        $content->save();
        return $this->redirect('?c=studio&a=listContent&s=1');
    }
}