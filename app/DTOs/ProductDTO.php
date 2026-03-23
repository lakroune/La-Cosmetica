<?php

namespace App\DTOs;

class ProductDTO
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public readonly string $name,
        public readonly ?string $description,
        public readonly float $price,
        public readonly int $stock,
        public readonly int $category_id,
        public readonly array $images
    ) {
        //
    }
}
