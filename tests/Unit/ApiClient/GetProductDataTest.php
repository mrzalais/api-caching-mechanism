<?php

declare(strict_types=1);

namespace Tests\Unit\ApiClient;

use App\ApiClient;
use App\Services\ProductFormattingService;
use App\Services\SizeTableFormattingService;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class GetProductDataTest extends TestCase
{
    public function test_it_returns_product_data(): void
    {
        $productId = 438;

        $mockGuzzleClient = $this->createMock(Client::class);

        $response = new Response(status: 200, body: json_encode([]));

        $mockGuzzleClient->expects($this->once())
            ->method('get')
            ->with("products/{$productId}")
            ->willReturn($response);

        $formattingServiceMock = $this->createMock(ProductFormattingService::class);

        $formattingServiceMock->expects($this->once())
            ->method('formatProduct')
            ->willReturn(['formatted' => 'product', 'data' => 'here']);

        $apiClient = $this->getMockBuilder(ApiClient::class)
            ->onlyMethods([])
            ->setConstructorArgs([$mockGuzzleClient, $formattingServiceMock, new SizeTableFormattingService()])
            ->getMock();

        $productData = $apiClient->getProductData($productId);
        $this->assertEquals(
            ['formatted' => 'product', 'data' => 'here'],
            $productData
        );
    }
}
