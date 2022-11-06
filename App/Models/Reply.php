<?php

namespace App\Models;

use App\Core\Model;

class Reply extends Model
{
    protected int $id;
    protected int $author;
    protected int $comment;
    protected string $post_time;
    protected string|null $modification_time;
    protected string $text;

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
     * @return int
     */
    public function getComment(): int
    {
        return $this->comment;
    }

    /**
     * @param int $comment
     */
    public function setComment(int $comment): void
    {
        $this->comment = $comment;
    }

    /**
     * @return string
     */
    public function getPostTime(): string
    {
        return $this->post_time;
    }

    /**
     * @param string $post_time
     */
    public function setPostTime(string $post_time): void
    {
        $this->post_time = $post_time;
    }

    /**
     * @return string|null
     */
    public function getModificationTime(): ?string
    {
        return $this->modification_time;
    }

    /**
     * @param string|null $modification_time
     */
    public function setModificationTime(?string $modification_time): void
    {
        $this->modification_time = $modification_time;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }


}