<?php

namespace App\DTO;

class ProductDTO
{
    public string $name;
    public int $price;

    /**
     * @param array<string, mixed> $data
     * @return ProductDTO
     */
    public static function instance(array $data): ProductDTO
    {
        $dto = new self();
        $dto->name = $data['name'] ?? '';
        $dto->price = $data['price'] ?? 0;

        return $dto;
    }
}
