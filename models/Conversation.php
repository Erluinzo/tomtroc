<?php

//conversation seen from one member, so it carries the other participant
class Conversation extends AbstractEntity
{
    private int $otherId = 0;
    private string $otherUsername = '';
    private ?string $otherAvatar = null;
    private ?string $lastMessage = null;
    private ?string $lastMessageAt = null;

    public function setOtherId(int $otherId): void
    {
        $this->otherId = $otherId;
    }

    public function getOtherId(): int
    {
        return $this->otherId;
    }

    public function setOtherUsername(string $otherUsername): void
    {
        $this->otherUsername = $otherUsername;
    }

    public function getOtherUsername(): string
    {
        return $this->otherUsername;
    }

    public function setOtherAvatar(?string $otherAvatar): void
    {
        $this->otherAvatar = $otherAvatar;
    }

    public function getOtherAvatar(): ?string
    {
        return $this->otherAvatar;
    }

    public function setLastMessage(?string $lastMessage): void
    {
        $this->lastMessage = $lastMessage;
    }

    public function getLastMessage(): ?string
    {
        return $this->lastMessage;
    }

    public function setLastMessageAt(?string $lastMessageAt): void
    {
        $this->lastMessageAt = $lastMessageAt;
    }

    public function getLastMessageAt(): ?string
    {
        return $this->lastMessageAt;
    }
}
