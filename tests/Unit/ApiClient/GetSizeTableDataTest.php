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

class GetSizeTableDataTest extends TestCase
{
    public function test_it_returns_product_data(): void
    {
        $productId = 438;
        $size = 'M';

        $mockClient = $this->createMock(ClientInterface::class);

        $response = new Response(status: 200, body: json_encode([]));

        $mockClient->expects($this->once())
            ->method('sendRequest')
            ->with($this->callback(function (Request $request) use ($productId) {
                return $request->getMethod() === 'GET' && (string)$request->getUri() === "products/{$productId}/sizes";
            }))
            ->willReturn($response);

        $formattingServiceMock = $this->createMock(SizeTableFormattingService::class);

        $formattingServiceMock->expects($this->once())
            ->method('formatSizeTables')
            ->willReturn(['formatted' => 'size', 'tables' => 'here']);

        $apiClient = $this->getMockBuilder(ApiClient::class)
            ->onlyMethods([])
            ->setConstructorArgs([$mockClient, new ProductFormattingService(), $formattingServiceMock])
            ->getMock();

        $productData = $apiClient->getSizeTableData($productId, $size);
        $this->assertEquals(
            ['formatted' => 'size', 'tables' => 'here'],
            $productData
        );
    }
}
