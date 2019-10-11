<?php
declare(strict_types=1);

class MatrixExcelTest extends TestCase
{
    public function testConvertReturnsEmptyArrayIfInputIsEmptyArray(): void
    {
        $parser = new \App\Models\MatrixExcel();
        $rows = [];
        $result = $parser->convert($rows);

        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    public function testConvertReturnsEmptyArrayIfSomeRowIsNotArray(): void
    {
        $parser = new \App\Models\MatrixExcel();
        $rows = [[1], 2, 3];
        $result = $parser->convert($rows);

        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    /**
     * @dataProvider rowsProvider
     */
    public function testConvertConvertsGivenArrayIndexToItsExcelColumn(array $rows, array $expected): void
    {
        $parser = new \App\Models\MatrixExcel();
        $result = $parser->convert($rows);

        $this->assertEquals($expected, $result);
    }

    public function rowsProvider(): array
    {
        return [
            'With index 0 should return index A' => [[[0 => 123]], [['A' => 123]]],
            'With index 1 should return index B' => [[[1 => 123]], [['B' => 123]]],
            'With index 2 should return index C' => [[[2 => 123]], [['C' => 123]]],
            'With index 3 should return index D' => [[[3 => 123]], [['D' => 123]]],
            'With index 4 should return index E' => [[[4 => 123]], [['E' => 123]]],
            'With index 5 should return index F' => [[[5 => 123]], [['F' => 123]]],
            'With index 6 should return index G' => [[[6 => 123]], [['G' => 123]]],
            'With index 7 should return index H' => [[[7 => 123]], [['H' => 123]]],
            'With index 8 should return index I' => [[[8 => 123]], [['I' => 123]]],
            'With index 9 should return index J' => [[[9 => 123]], [['J' => 123]]],
            'With index 10 should return index K' => [[[10 => 123]], [['K' => 123]]],
            'With index 25 should return index Z' => [[[25 => 123]], [['Z' => 123]]],
            'With index 26 should return index AA' => [[[26 => 123]], [['AA' => 123]]],
            'With index 27 should return index AB' => [[[27 => 123]], [['AB' => 123]]],
            'With multiple indexes should return their mapped columns' => [
                [[
                    0 => 123,
                    100 => 123,
                    210 => 123,
                    400 => 123,
                    502 => 123,
                    650 => 123,
                    899 => 123,
                    1200 => 123,
                    1300 => 123,
                    1500 => 123
                ]],
                [[
                    'A' => 123,
                    'CW' => 123,
                    'HC' => 123,
                    'OK' => 123,
                    'SI' => 123,
                    'YA' => 123,
                    'AHP' => 123,
                    'ATE' => 123,
                    'AXA' => 123,
                    'BES' => 123
                ]]
            ]
        ];
    }
}
