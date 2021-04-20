<?php

namespace App\Entity;

class Product
{
    public int $id;
    public string $title;
    public string $artist;
    public string $imagePath;
    public string $genre;
    public ?float $average_rating;
    /** @var CheckIn[] */
    public array $checkIns = [];

    public function __construct()
    {
        //echo 'I was instantiated';
    }


    public function addCheckin(CheckIn $checkIn): void
    {
        $this->checkIns[] = $checkIn;
    }

    public function getCheckIns(): array
    {
        return $this->checkIns;
    }
}
