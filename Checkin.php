<?php

namespace App\Entity;

class CheckIn
{
    public ?int $id;
    public int $product_id;
    public string $name;
    public int $rating;
    public string $review;
    public ?string $posted;
}

