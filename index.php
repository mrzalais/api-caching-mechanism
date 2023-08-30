<?php

declare(strict_types=1);

use App\ApiClient;
use App\Cache;
use App\Enums\Size;
use App\Services\ProductFormattingService;
use App\Services\SizeTableFormattingService;
use GuzzleHttp\Client;

require 'vendor/autoload.php';

$guzzleClient = new Client([
    'base_uri' => 'https://api.printful.com/',
]);

$apiClient = new ApiClient($guzzleClient, new ProductFormattingService(), new SizeTableFormattingService());
$cache = new Cache(__DIR__ . '/cache');

$productId = 438;
$size = Size::Large->value;
$cacheKey = "product_{$productId}_size_{$size}";

$cachedData = $cache->get($cacheKey);

if ($cachedData !== null) {
    $productAndSizeData = $cachedData;
} else {
    $productAndSizeData = $apiClient->getProductAndSizeData($productId, $size);

    // Store data in cache for 5 minutes
    $cache->set($cacheKey, $productAndSizeData, 300);
}

print_r($productAndSizeData);
