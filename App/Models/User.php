<?php
namespace App\Models;

use App\Core\Model;

class User extends Model
{
    protected int $id;
    protected string $login;
    protected string $password;
    protected string|null $profile_picture;
    protected string|null $email;

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
     * @return mixed
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @param mixed $login
     */
    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    /**
     * @return mixed
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string|null
     */
    public function getProfilePicture(): string|null
    {
        return $this->profile_picture;
    }

    /**
     * @param mixed $profile_picture
     */
    public function setProfilePicture(string|null $profile_picture): void
    {
        $this->profile_picture = $profile_picture;
    }

    /**
     * @return string|null
     */
    public function getEmail(): string|null
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail(string|null $email): void
    {
        $this->email = $email;
    }


}