<?php
namespace App\Models;

use App\Core\Model;

class Comment extends Model
{
    protected int $id;
    protected int $author;
    protected string $video;
    protected string $post_time;
    protected string|null $modification_time;
    protected string $text;
    protected int|null $reply_to;

    public function __construct()
    {
        $this->reply_to = null;
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
     * @throws \Exception
     */
    public function getReplies(): array
    {
        try {
            return Comment::getAll("reply_to = ?", [$this->getId()]);
        } catch (\Exception $e) {
            throw new \Exception('Error when getting replies: ' . $e->getMessage(), 0, $e);
        }
    }

    public function setAtributes(int $author, int $video, string $postTime, string $text, string $modificationTime = null, int $replyTo = null): void {
        $this->author = $author;
        $this->video = $video;
        $this->post_time = $postTime;
        $this->modification_time = $modificationTime;
        $this->text = $text;
        if ($this->reply_to == null) {
            $this->reply_to = $replyTo;
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
     * @return string
     */
    public function getModificationTime(): string|null
    {
        return $this->modification_time;
    }

    /**
     * @param string $modification_time
     */
    public function setModificationTime(string $modification_time): void
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

    /**
     * @return int
     */
    public function getReplyTo(): int|null
    {
        return $this->reply_to;
    }

    /**
     * @param int $reply_to
     */
    public function setReplyTo(int $reply_to): void
    {
        $this->reply_to = $reply_to;
    }


}