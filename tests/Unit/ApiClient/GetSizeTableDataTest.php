<?php

declare(strict_types=1);

namespace Tests\Unit\ApiClient;

use App\ApiClient;
use App\Services\ProductFormattingService;
use App\Services\SizeTableFormattingService;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class GetSizeTableDataTest extends TestCase
{
    public function test_it_returns_product_data(): void
    {
        $productId = 438;
        $size = 'M';

        $mockGuzzleClient = $this->createMock(Client::class);

        $response = new Response(status: 200, body: json_encode([]));

        $mockGuzzleClient->expects($this->once())
            ->method('get')
            ->with("products/{$productId}/sizes")
            ->willReturn($response);

        $formattingServiceMock = $this->createMock(SizeTableFormattingService::class);

        $formattingServiceMock->expects($this->once())
            ->method('formatSizeTables')
            ->willReturn(['formatted' => 'size', 'tables' => 'here']);

        $apiClient = $this->getMockBuilder(ApiClient::class)
            ->onlyMethods([])
            ->setConstructorArgs([$mockGuzzleClient, new ProductFormattingService(), $formattingServiceMock])
            ->getMock();

        $productData = $apiClient->getSizeTableData($productId, $size);
        $this->assertEquals(
            ['formatted' => 'size', 'tables' => 'here'],
            $productData
        );
    }
}
