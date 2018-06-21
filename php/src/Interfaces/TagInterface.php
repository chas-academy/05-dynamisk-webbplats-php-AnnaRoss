<?php

namespace App\Interfaces;

class TagInterface
{
    private $id, $title;

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}
