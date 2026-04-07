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

class GetProductDataTest extends TestCase
{
    public function test_it_returns_product_data(): void
    {
        $productId = 438;

        $mockClient = $this->createMock(ClientInterface::class);

        $response = new Response(status: 200, body: json_encode([]));

        $mockClient->expects($this->once())
            ->method('sendRequest')
            ->with($this->callback(function (Request $request) use ($productId) {
                return $request->getMethod() === 'GET' && (string)$request->getUri() === "products/{$productId}";
            }))
            ->willReturn($response);

        $formattingServiceMock = $this->createMock(ProductFormattingService::class);

        $formattingServiceMock->expects($this->once())
            ->method('formatProduct')
            ->willReturn(['formatted' => 'product', 'data' => 'here']);

        $apiClient = $this->getMockBuilder(ApiClient::class)
            ->onlyMethods([])
            ->setConstructorArgs([$mockClient, $formattingServiceMock, new SizeTableFormattingService()])
            ->getMock();

        $productData = $apiClient->getProductData($productId);
        $this->assertEquals(
            ['formatted' => 'product', 'data' => 'here'],
            $productData
        );
    }
}
