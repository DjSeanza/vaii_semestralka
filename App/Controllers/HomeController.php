<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\DB\Connection;
use App\Core\DB\DebugStatement;
use App\Core\Responses\Response;
use App\Models\Video;
use PDO;

/**
 * Class HomeController
 * Example class of a controller
 * @package App\Controllers
 */
class HomeController extends AControllerBase
{
    /**
     * @throws \Exception
     */
    public function index(): Response
    {
        $query = Connection::connect()->prepare("SELECT * FROM videos LIMIT 8");
        $query->execute([]);
        $generatedVideos = $this->fetchAllVideos($query);

        return $this->html(["generatedVideos" => $generatedVideos], viewName: "index");
    }

    /**
     * @throws \Exception
     */
    public function generateContent(): Response|null {
        if ($this->request()->isAjax()) {
            $offset = $this->request()->getValue("offset");
            $query = Connection::connect()->prepare("SELECT * FROM videos LIMIT 8 OFFSET " . $offset);
            $query->execute([]);
            $generatedVideos = $this->fetchAllVideos($query);

            for ($i = 0; $i < count($generatedVideos); $i++) {
                $generatedVideos[$i] = array("author" => $generatedVideos[$i]->getAuthorName(), "video" => $generatedVideos[$i]);
            }

            return $this->json($generatedVideos);
        }

        return null;
    }

    private function fetchAllVideos(DebugStatement $query): array {
        $generatedVideos = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $video = new Video();
            $video->setId($row['id']);
            $video->setThumbnail($row['thumbnail']);
            $video->setAttributes($row['title'], $row['description'], intval($row['category']), intval($row['author']), $row['post_date'], intval($row['views']));
            $generatedVideos[] = $video;
        }

        return $generatedVideos;
    }
}