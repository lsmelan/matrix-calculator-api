<?php
declare(strict_types=1);

namespace App\Models;

use App\Contracts\MatrixParser;

class MatrixExcel implements MatrixParser
{
    public function convert(array $rows): array
    {
        $newRows = [];

        foreach ($rows as $rowKey => $columns) {
            if (!is_array($columns)) {
                return [];
            }

            foreach ($columns as $columnKey => $columnValue) {
                $newRows[$rowKey][$this->getExcelColumn($columnKey + 1)] = $columnValue;
            }
        }

        return $newRows;
    }

    private function getExcelColumn(int $number): string
    {
        $letters = [];

        while ($number) {
            $remainder = $number % 26;

            if ($remainder) {
                $letters[] = chr(($remainder - 1) + ord('A'));
                $number = (int) ($number / 26);
                continue;
            }

            $letters[] = 'Z';
            $number = ((int) ($number / 26)) - 1;
        }

        return implode("", array_reverse($letters));
    }
}
