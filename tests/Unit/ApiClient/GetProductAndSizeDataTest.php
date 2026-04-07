<?php

declare(strict_types=1);

namespace Tests\Unit\ApiClient;

use App\ApiClient;
use App\Services\ProductFormattingService;
use App\Services\SizeTableFormattingService;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;

class GetProductAndSizeDataTest extends TestCase
{
    public function test_it_returns_product_and_size_tables_data(): void
    {
        $productId = 438;
        $size = 'M';

        $mockClient = $this->createMock(ClientInterface::class);

        $response = new Response(status: 200, body: json_encode([]));

        $mockClient->method('sendRequest')
            ->with($this->callback(function (Request $request) use ($productId) {
                return $request->getMethod() === 'GET' && (string)$request->getUri() === "products/{$productId}";
            }))
            ->willReturn($response);

        $apiClient = $this->getMockBuilder(ApiClient::class)
            ->setConstructorArgs([$mockClient, new ProductFormattingService(), new SizeTableFormattingService()])
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
