<?php

declare(strict_types=1);

namespace App;

use App\Services\DataFormattingService;
use GuzzleHttp\Client;

class ApiClient
{
    public function __construct(
        protected readonly Client $client,
        protected readonly DataFormattingService $dataFormattingService
    ) {
    }

    public function getProductAndSizeData(int $productId, string $size): array
    {
        $productData = $this->getProductData($productId);
        $sizeTables = $this->getSizeTableData($productId, $size);

        return [
            'product' => $productData,
            'size_tables' => $sizeTables,
        ];
    }

    public function getProductData(int $productId): array
    {
        $response = $this->client->get("products/{$productId}");
        $data = json_decode($response->getBody()->getContents(), true);

        return $this->dataFormattingService->formatProduct($data);
    }

    public function getSizeTableData(int $productId, string $size): array
    {
        $response = $this->client->get("products/{$productId}/sizes");
        $data = json_decode($response->getBody()->getContents(), true);

        return $this->dataFormattingService->formatSizeTables($data, $size);
    }
}
