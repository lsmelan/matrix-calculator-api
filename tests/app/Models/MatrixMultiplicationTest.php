<?php
declare(strict_types=1);

class MatrixMultiplicationTest extends TestCase
{
    private $parser;

    protected function setUp(): void
    {
        $this->parser = $this->getMockBuilder('App\Contracts\MatrixParser')
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testCalculateSetsEmptyResultIfValueIsNotSet(): void
    {
        $multiplication = new \App\Models\MatrixMultiplication($this->parser);
        $multiplication->calculate();
        $this->assertEmpty($multiplication->result());
    }

    /**
     * @expectedException App\Exceptions\InvalidMatrixException
     */
    public function testCalculateThrowsExceptionWhenMatricesNotValid(): void
    {
        $multiplication = new \App\Models\MatrixMultiplication($this->parser);
        $multiplication->setValues([[1, 2, 3]], [[1, 2]]);
        $multiplication->calculate();
    }

    /**
     * @dataProvider matricesProvider
     */
    public function testCalculateMultipliesGivenMatrices(array $matrixA, array $matrixB, array $expected): void
    {
        $this->parser->expects($this->once())
            ->method('convert')
            ->with($expected);

        $multiplication = new \App\Models\MatrixMultiplication($this->parser);
        $multiplication->setValues($matrixA, $matrixB);
        $multiplication->calculate()->result();
    }

    public function matricesProvider(): array
    {
        return [
            'With 2x3 and 3x2 returns 2x2' => [
                [[1, 2, 3], [4, 5, 6]], [[7, 8], [9, 10], [11, 12]], [[58, 64], [139, 154]]
            ],
            'With 2x2 and 2x2 return 2x2' => [
                [[1, 2], [3, 4]], [[5, 6], [7, 8]], [[19, 22], [43, 50]]
            ],
            'With 2x2 and 2x2 sets hidden column as 0 and returns 2x2' => [
                [[1, 2], [3, 4]], [[5, 6], [7]], [[19, 6], [43, 18]]
            ],
            'With 1x3 and 3x1 returns 1x1' => [
                [[1, 2, 3]], [[4], [5], [6]], [[32]]
            ],
        ];
    }
}
