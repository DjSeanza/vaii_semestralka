<?php

namespace App\Models;

use App\Core\Model;

class Video extends Model
{
    protected int $id;
    protected string $title;
    protected int $author;
    protected string $description;
    protected string $post_date;
    protected string $thumbnail;
    protected string $video;
    protected int $category;
    protected int $views;

    /**
     * @throws \Exception
     */
    public function getComments(): array
    {
        try {
            return Comment::getAll('video = ?', [$this->getId()]);
        } catch (\Exception $e) {
            throw new \Exception('Comments not found: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * @throws \Exception
     */
    public function getAuthorName(): string
    {
        try {
            return User::getOne($this->getAuthor())->getLogin();
        } catch (\Exception $e) {
            throw new \Exception('User not found: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return int
     */
    public function getAuthor(): int
    {
        return $this->author;
    }

    /**
     * @param int $author
     */
    public function setAuthor(int $author): void
    {
        $this->author = $author;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getPostDate(): string
    {
        return $this->post_date;
    }

    /**
     * @param string $post_date
     */
    public function setPostDate(string $post_date): void
    {
        $this->post_date = $post_date;
    }

    /**
     * @return string
     */
    public function getThumbnail(): string
    {
        return $this->thumbnail;
    }

    /**
     * @param string $thumbnail
     */
    public function setThumbnail(string $thumbnail): void
    {
        $this->thumbnail = $thumbnail;
    }

    /**
     * @return string
     */
    public function getVideo(): string
    {
        return $this->video;
    }

    /**
     * @param string $video
     */
    public function setVideo(string $video): void
    {
        $this->video = $video;
    }

    /**
     * @return int
     */
    public function getCategory(): int
    {
        return $this->category;
    }

    /**
     * @param int $category
     */
    public function setCategory(int $category): void
    {
        $this->category = $category;
    }

    /**
     * @return int
     */
    public function getViews(): int
    {
        return $this->views;
    }

    /**
     * @param int $views
     */
    public function setViews(int $views): void
    {
        $this->views = $views;
    }
}