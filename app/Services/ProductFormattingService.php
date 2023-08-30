<?php

declare(strict_types=1);

namespace App\Services;

class ProductFormattingService
{
    public function formatProduct(array $data): array
    {
        $product = $data['result']['product'];

        return [
            'id' => $product['id'],
            'title' => $product['title'],
            'description' => $product['description'],
        ];
    }
}
