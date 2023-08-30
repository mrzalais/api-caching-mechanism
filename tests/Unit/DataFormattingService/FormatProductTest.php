<?php

declare(strict_types=1);

namespace Tests\Unit\DataFormattingService;

use App\Services\ProductFormattingService;
use PHPUnit\Framework\TestCase;

class FormatProductTest extends TestCase
{
    public function test_it_returns_formatted_product_data(): void
    {
        $productFormattingService = new ProductFormattingService();
        $formattedData = $productFormattingService->formatProduct($this->getExampleProductData());

        $this->assertEquals(
            [
                'id' => 13,
                'title' => 'Unisex Staple T-Shirt | Bella + Canvas 3001',
                'description' => 'string',
            ],
            $formattedData
        );
    }

    private function getExampleProductData(): array
    {
        return [
            'code' => 200,
            'result' => [
                'product' => [
                    'id' => 13,
                    'main_category_id' => 24,
                    'type' => 'T-SHIRT',
                    'type_name' => 'T-Shirt',
                    'title' => 'Unisex Staple T-Shirt | Bella + Canvas 3001',
                    'brand' => 'Gildan',
                    'model' => '2200 Ultra Cotton Tank Top',
                    'image' => 'https://files.cdn.printful.com/products/12/product_1550594502.jpg',
                    'variant_count' => 30,
                    'currency' => 'EUR',
                    'files' => [
                        [
                            'id' => 'default',
                            'type' => 'front',
                            'title' => 'Front print',
                            'additional_price' => '2.22',
                            'options' => [
                                [
                                    'id' => 'full_color',
                                    'type' => 'bool',
                                    'title' => 'Unlimited color',
                                    'additional_price' => 3.25
                                ]
                            ]
                        ]
                    ],
                    'options' => [
                        [
                            'id' => 'embroidery_type',
                            'title' => 'Embroidery type',
                            'type' => 'radio',
                            'values' => [
                                'flat' => 'Flat Embroidery',
                                '3d' => '3D Puff',
                                'both' => 'Partial 3D Puff'
                            ],
                            'additional_price' => 'string',
                            'additional_price_breakdown' => [
                                'flat' => '0.00',
                                '3d' => '0.00',
                                'both' => '0.00'
                            ]
                        ]
                    ],
                    'is_discontinued' => false,
                    'avg_fulfillment_time' => 4.3,
                    'description' => 'string',
                    'techniques' => [
                        [
                            'key' => 'DTG',
                            'display_name' => 'DTG printing',
                            'is_default' => true
                        ]
                    ],
                    'origin_country' => 'Nicaragua'
                ],
                'variants' => [
                    [
                        'id' => 100,
                        'product_id' => 12,
                        'name' => 'Gildan 64000 Unisex Softstyle T-Shirt with Tear Away (Black / 2XL)',
                        'size' => '2XL',
                        'color' => 'Black',
                        'color_code' => '#14191e',
                        'color_code2' => 'string',
                        'image' => 'https://files.cdn.printful.com/products/12/629_1517916489.jpg',
                        'price' => '9.85',
                        'in_stock' => true,
                        'availability_regions' => [
                            'US' => 'USA',
                            'EU' => 'Europe'
                        ],
                        'availability_status' => [
                            [
                                'region' => 'US',
                                'status' => 'in_stock'
                            ]
                        ],
                        'material' => [
                            [
                                'name' => 'cotton',
                                'percentage' => 100
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }
}
