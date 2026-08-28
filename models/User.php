<?php

//user entity
class User extends AbstractEntity
{
    //sizes of the users columns
    public const USERNAME_MAX_LENGTH = 50;
    public const EMAIL_MAX_LENGTH = 180;
    public const PASSWORD_MIN_LENGTH = 6;
    public const PASSWORD_MAX_LENGTH = 72;

    private string $username;
    private string $email;
    private string $password;
    private ?string $avatar = null;
    private string $createdAt;

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setAvatar(?string $avatar): void
    {
        $this->avatar = $avatar;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }
}
