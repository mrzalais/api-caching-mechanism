<?php

declare(strict_types=1);

namespace App\Services;

class DataFormattingService
{
    public function formatSizeTables(array $data, string $size): array
    {
        $formattedSizeTables = [];

        foreach ($data['result']['size_tables'] as $sizeTableData) {
            $formattedSizeTable = [
                'type' => $sizeTableData['type'],
                'unit' => $sizeTableData['unit'],
                'description' => $sizeTableData['description'] ?? '',
            ];
            foreach ($sizeTableData['measurements'] as $measurement) {
                foreach ($measurement['values'] as $key => $sizeEntry) {
                    if ($sizeEntry['size'] === $size) {
                        if (isset($measurement['values'][$key]['value'])) {
                            $formattedSizeTable['measurements'][] = [
                                'type_label' => $measurement['type_label'],
                                'value' => $sizeEntry['value']
                            ];
                        } else {
                            $formattedSizeTable['measurements'][] = [
                                'type_label' => $measurement['type_label'],
                                'min_value' => $sizeEntry['min_value'],
                                'max_value' => $sizeEntry['max_value']
                            ];
                        }
                    }
                }
            }
            $formattedSizeTables[] = $formattedSizeTable;
        }

        return $formattedSizeTables;
    }

    public function formatProduct(array $data): array
    {
        $product = $data['result']['product'];

        return [
            'id' => $product['id'],
            'title' => $product['title'],
            'description' => $product['description'],
        ];
    }
}
