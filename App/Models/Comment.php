<?php
namespace App\Models;

use App\Core\Model;

class Comment extends Model
{
    protected $id;
    protected $author;
    protected $video;
    protected $post_time;
    protected $modification_time;
    protected $text;
    protected $reply_to;

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

    public function setAtributes(int $author, int $video, string $postTime, string $modificationTime = null, string $text, int $replyTo = null): void {
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
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author): void
    {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * @param mixed $video
     */
    public function setVideo($video): void
    {
        $this->video = $video;
    }

    /**
     * @return mixed
     */
    public function getPostTime()
    {
        return $this->post_time;
    }

    /**
     * @param mixed $post_time
     */
    public function setPostTime($post_time): void
    {
        $this->post_time = $post_time;
    }

    /**
     * @return mixed
     */
    public function getModificationTime()
    {
        return $this->modification_time;
    }

    /**
     * @param mixed $modification_time
     */
    public function setModificationTime($modification_time): void
    {
        $this->modification_time = $modification_time;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text): void
    {
        $this->text = $text;
    }

    /**
     * @return mixed
     */
    public function getReplyTo()
    {
        return $this->reply_to;
    }

    /**
     * @param mixed $reply_to
     */
    public function setReplyTo($reply_to): void
    {
        $this->reply_to = $reply_to;
    }


}