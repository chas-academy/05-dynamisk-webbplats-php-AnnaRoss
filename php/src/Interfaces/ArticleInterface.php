<?php

namespace App\Interfaces;

class ArticleInterface
{
    private $id, $headline, $content, $publication_date, $user_id;

    protected $category, $tags;

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
    
    public function getUserId()
    {
        return $this->user_id;
    }

    public function setCategory($category)
    {
        $this->category = $category;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    public function getTags()
    {
        return $this->tags;
    }
}
