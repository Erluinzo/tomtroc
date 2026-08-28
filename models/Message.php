<?php

//message entity
class Message extends AbstractEntity
{
    public const CONTENT_MAX_LENGTH = 2000;

    private int $senderId;
    private string $content;
    private string $createdAt;

    public function setSenderId(int $senderId): void
    {
        $this->senderId = $senderId;
    }

    public function getSenderId(): int
    {
        return $this->senderId;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getContent(): string
    {
        return $this->content;
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
