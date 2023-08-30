<?php

declare(strict_types=1);

namespace Tests\Unit\ApiClient;

use App\ApiClient;
use App\Services\ProductFormattingService;
use App\Services\SizeTableFormattingService;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class GetProductAndSizeDataTest extends TestCase
{
    public function test_it_returns_product_and_size_tables_data(): void
    {
        $productId = 438;
        $size = 'M';

        $mockGuzzleClient = $this->createMock(Client::class);

        $response = new Response(status: 200, body: json_encode([]));

        $mockGuzzleClient->method('get')
            ->with("products/{$productId}")
            ->willReturn($response);

        $apiClient = $this->getMockBuilder(ApiClient::class)
            ->setConstructorArgs([$mockGuzzleClient, new ProductFormattingService(), new SizeTableFormattingService()])
            ->onlyMethods(['getProductData', 'getSizeTableData'])
            ->getMock();

        $apiClient->expects($this->once())
            ->method('getProductData')
            ->with($productId)
            ->willReturn(['formattedProductData']);

        $apiClient->expects($this->once())
            ->method('getSizeTableData')
            ->with($productId, $size)
            ->willReturn(['formattedSizeTablesData']);

        $productAndSizeData = $apiClient->getProductAndSizeData(438, 'M');

        $this->assertEquals(
            [
                'product' => ['formattedProductData'],
                'size_tables' => ['formattedSizeTablesData'],
            ],
            $productAndSizeData
        );
    }
}
