<?php

namespace App\Interfaces;

class ArticleInterface
{
    private $id, $headline, $content, $publication_date;

    protected $category;

    public function getId(): int
    {
        return $this->id;
    }

    public function getHeadline(): string
    {
        return $this->headline;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getPublicationDate(): string
    {
        return $this->publication_date;
    }

    public function setCategory($category) {
        $this->category = $category;
    }

    public function getCategory() {
        return $this->category;
    }
}
