<?php

declare(strict_types=1);

namespace Tests\Unit\DataFormattingService;

use App\Services\SizeTableFormattingService;
use PHPUnit\Framework\TestCase;

class FormatSizeTableTest extends TestCase
{
    public function test_it_returns_correctly_formatted_data_based_on_provided_size(): void
    {
        $sizeTableFormattingService = new SizeTableFormattingService();
        $formattedData = $sizeTableFormattingService->formatSizeTables($this->getExampleSizeTableData(), 'S');

        $this->assertEquals($this->getExpectedData(), $formattedData);
    }

    private function getExpectedData(): array
    {
        return [
            [
                "type" => "measure_yourself",
                "unit" => "inches",
                "description" => "inches measure_yourself description",
                "measurements" => [
                    [
                        "type_label" => "Length",
                        "value" => "24"
                    ],
                    [
                        "type_label" => "Chest",
                        "min_value" => "14",
                        "max_value" => "16"
                    ]
                ]
            ],
            [
                "type" => "product_measure",
                "unit" => "inches",
                "description" => "inches product_measure description",
                "measurements" => [
                    [
                        "type_label" => "Length",
                        "value" => "24"
                    ],
                    [
                        "type_label" => "Width",
                        "min_value" => "14",
                        "max_value" => "16"
                    ]
                ]
            ],
            [
                "type" => "measure_yourself",
                "unit" => "cm",
                "description" => "cm measure_yourself description",
                "measurements" => [
                    [
                        "type_label" => "Length",
                        "value" => "60.96"
                    ],
                    [
                        "type_label" => "Chest",
                        "min_value" => "35.56",
                        "max_value" => "40.64"
                    ]
                ]
            ],
            [
                "type" => "product_measure",
                "unit" => "cm",
                "description" => "cm product_measure description",
                "measurements" => [
                    [
                        "type_label" => "Length",
                        "value" => "60.96"
                    ],
                    [
                        "type_label" => "Width",
                        "min_value" => "35.56",
                        "max_value" => "40.64"
                    ]
                ]
            ],
            [
                "type" => "international",
                "unit" => "none",
                "description" => "",
                "measurements" => [
                    [
                        "type_label" => "US size",
                        "min_value" => "8",
                        "max_value" => "10"
                    ],
                    [
                        "type_label" => "EU size",
                        "min_value" => "38",
                        "max_value" => "39"
                    ],
                    [
                        "type_label" => "UK size",
                        "min_value" => "4",
                        "max_value" => "6"
                    ]
                ]
            ]
        ];
    }

    private function getExampleSizeTableData(): array
    {
        return [
            'code' => 200,
            'result' => [
                'product_id' => 13,
                'available_sizes' => ['S', 'M', 'L'],
                'size_tables' => [
                    [
                        'type' => 'measure_yourself',
                        'unit' => 'inches',
                        'description' => 'inches measure_yourself description',
                        'image_url' => 'inches example image_url',
                        'image_description' => 'inches measure_yourself image_description',
                        'measurements' => [
                            [
                                'type_label' => 'Length',
                                'values' => [
                                    ['size' => 'S', 'value' => '24'],
                                    ['size' => 'M', 'value' => '26'],
                                    ['size' => 'L', 'value' => '28']
                                ]
                            ],
                            [
                                'type_label' => 'Chest',
                                'values' => [
                                    ['size' => 'S', 'min_value' => '14', 'max_value' => '16'],
                                    ['size' => 'M', 'min_value' => '18', 'max_value' => '20'],
                                    ['size' => 'L', 'min_value' => '22', 'max_value' => '24']
                                ]
                            ]
                        ]
                    ],
                    [
                        'type' => 'product_measure',
                        'unit' => 'inches',
                        'description' => 'inches product_measure description',
                        'image_url' => 'inches product_measure image_url',
                        'image_description' => 'inches product_measure image_description',
                        'measurements' => [
                            [
                                'type_label' => 'Length',
                                'values' => [
                                    ['size' => 'S', 'value' => '24'],
                                    ['size' => 'M', 'value' => '26'],
                                    ['size' => 'L', 'value' => '28']
                                ]
                            ],
                            [
                                'type_label' => 'Width',
                                'values' => [
                                    ['size' => 'S', 'min_value' => '14', 'max_value' => '16'],
                                    ['size' => 'M', 'min_value' => '18', 'max_value' => '20'],
                                    ['size' => 'L', 'min_value' => '22', 'max_value' => '24']
                                ]
                            ]
                        ]
                    ],
                    [
                        'type' => 'measure_yourself',
                        'unit' => 'cm',
                        'description' => 'cm measure_yourself description',
                        'image_url' => 'cm measure_yourself image_url',
                        'image_description' => 'cm measure_yourself image_description',
                        'measurements' => [
                            [
                                'type_label' => 'Length',
                                'values' => [
                                    ['size' => 'S', 'value' => '60.96'],
                                    ['size' => 'M', 'value' => '66.04'],
                                    ['size' => 'L', 'value' => '71.12']
                                ]
                            ],
                            [
                                'type_label' => 'Chest',
                                'values' => [
                                    ['size' => 'S', 'min_value' => '35.56', 'max_value' => '40.64'],
                                    ['size' => 'M', 'min_value' => '45.72', 'max_value' => '50.80'],
                                    ['size' => 'L', 'min_value' => '55.88', 'max_value' => '60.96']
                                ]
                            ]
                        ]
                    ],
                    [
                        'type' => 'product_measure',
                        'unit' => 'cm',
                        'description' => 'cm product_measure description',
                        'image_url' => 'cm product_measure image_url',
                        'image_description' => 'cm product_measure image_description',
                        'measurements' => [
                            [
                                'type_label' => 'Length',
                                'values' => [
                                    ['size' => 'S', 'value' => '60.96'],
                                    ['size' => 'M', 'value' => '66.04'],
                                    ['size' => 'L', 'value' => '71.12']
                                ]
                            ],
                            [
                                'type_label' => 'Width',
                                'values' => [
                                    ['size' => 'S', 'min_value' => '35.56', 'max_value' => '40.64'],
                                    ['size' => 'M', 'min_value' => '45.72', 'max_value' => '50.80'],
                                    ['size' => 'L', 'min_value' => '55.88', 'max_value' => '60.96']
                                ]
                            ]
                        ]
                    ],
                    [
                        'type' => 'international',
                        'unit' => 'none',
                        'measurements' => [
                            [
                                'type_label' => 'US size',
                                'values' => [
                                    ['size' => 'S', 'min_value' => '8', 'max_value' => '10'],
                                    ['size' => 'M', 'min_value' => '12', 'max_value' => '14'],
                                    ['size' => 'L', 'min_value' => '16', 'max_value' => '18']
                                ]
                            ],
                            [
                                'type_label' => 'EU size',
                                'values' => [
                                    ['size' => 'S', 'min_value' => '38', 'max_value' => '39'],
                                    ['size' => 'M', 'min_value' => '40', 'max_value' => '41'],
                                    ['size' => 'L', 'min_value' => '42', 'max_value' => '43']
                                ]
                            ],
                            [
                                'type_label' => 'UK size',
                                'values' => [
                                    ['size' => 'S', 'min_value' => '4', 'max_value' => '6'],
                                    ['size' => 'M', 'min_value' => '8', 'max_value' => '10'],
                                    ['size' => 'L', 'min_value' => '12', 'max_value' => '14']
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }
}
