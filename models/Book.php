<?php

//book entity
class Book extends AbstractEntity
{
    private string $title;
    private string $author;
    private ?string $cover = null;
    private string $ownerName;

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setCover(?string $cover): void
    {
        $this->cover = $cover;
    }

    public function getCover(): ?string
    {
        return $this->cover;
    }

    //name of the member who owns the book, filled from a join
    public function setOwnerName(string $ownerName): void
    {
        $this->ownerName = $ownerName;
    }

    public function getOwnerName(): string
    {
        return $this->ownerName;
    }
}
