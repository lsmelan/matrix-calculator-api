<?php
declare(strict_types=1);

class MatrixCalculatorTest extends TestCase
{
    private $calculator;

    protected function setUp(): void
    {
        $this->calculator = new class extends \App\Models\MatrixCalculator
        {
            public function calculate(): Object
            {
                return $this;
            }
        };
    }

    public function testGetCurrentValueReturnsEmptyIfNoValueIsSet(): void
    {
        $expected = [];
        $result = $this->calculator->getCurrentValue();
        $this->assertEquals($expected, $result);
    }

    public function testGetCurrentValueReturnsCurrentValueAfterSettingIt(): void
    {
        $value1 = [123];
        $value2 = [456];
        $expected = $value1;

        $this->calculator->setValues($value1, $value2);
        $result = $this->calculator->getCurrentValue();
        $this->assertEquals($expected, $result);
    }

    public function testFirstMovesCursorToFirstElement(): void
    {
        $value1 = [123];
        $value2 = [456];
        $expected = $value1;

        $this->calculator->setValues($value1, $value2);
        $result = $this->calculator->first()->getCurrentValue();
        $this->assertEquals($expected, $result);
    }

    public function testLastMovesCursorToLastElement(): void
    {
        $value1 = [123];
        $value2 = [456];
        $expected = $value2;

        $this->calculator->setValues($value1, $value2);
        $result = $this->calculator->last()->getCurrentValue();
        $this->assertEquals($expected, $result);
    }

    public function testCountRowsReturnsZeroIfNoValueIsSet(): void
    {
        $result = $this->calculator->countRows();
        $this->assertEquals(0, $result);
    }

    public function testCountRowsReturnsNumberOfRowsOfTheCurrentValue(): void
    {
        $value1 = [[123], [123], [123]];
        $value2 = [[456], [456]];
        $expected = $value2;

        $this->calculator->setValues($value1, $value2);
        $result = $this->calculator->countRows();
        $this->assertEquals(3, $result);
    }

    public function testCountColumnsReturnsZeroIfNoValueIsSet(): void
    {
        $result = $this->calculator->countColumns();
        $this->assertEquals(0, $result);
    }

    public function testCountColumnsReturnsNumberOfColumnsOfTheCurrentValue(): void
    {
        $value1 = [[1, 2, 3, 4]];
        $value2 = [[5, 6, 7, 8]];
        $expected = $value2;

        $this->calculator->setValues($value1, $value2);
        $result = $this->calculator->countColumns();
        $this->assertEquals(4, $result);
    }

    public function testResultReturnsEmptyArrayByDefault(): void
    {
        $expected = [];
        $result = $this->calculator->result();
        $this->assertEquals($expected, $result);
    }

    public function testCalculateShouldReturnAnObject(): void
    {
        $result = $this->calculator->calculate();
        $this->assertIsObject($result);
    }
}
