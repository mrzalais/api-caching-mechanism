<?php

declare(strict_types=1);

namespace App;

use App\Services\SizeTableFormattingService;
use App\Services\ProductFormattingService;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;

class ApiClient
{
    public function __construct(
        protected readonly ClientInterface $client,
        protected readonly ProductFormattingService $productDataFormattingService,
        protected readonly SizeTableFormattingService $sizeTableFormattingService,
    ) {
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function getProductAndSizeData(int $productId, string $size): array
    {
        $productData = $this->getProductData($productId);
        $sizeTables = $this->getSizeTableData($productId, $size);

        return [
            'product' => $productData,
            'size_tables' => $sizeTables,
        ];
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function getProductData(int $productId): array
    {
        $request = new Request('GET', "products/{$productId}");
        $response = $this->client->sendRequest($request);
        $data = json_decode($response->getBody()->getContents(), true);

        return $this->productDataFormattingService->formatProduct($data);
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function getSizeTableData(int $productId, string $size): array
    {
        $request = new Request('GET', "products/{$productId}/sizes");
        $response = $this->client->sendRequest($request);
        $data = json_decode($response->getBody()->getContents(), true);

        return $this->sizeTableFormattingService->formatSizeTables($data, $size);
    }
}
