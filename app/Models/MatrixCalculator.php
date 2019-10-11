<?php
declare(strict_types=1);

namespace App\Models;

abstract class MatrixCalculator
{
    private $values;
    protected $result;

    public function __construct()
    {
        $this->values = [[], []];
        $this->result = [];
    }

    public function setValues(array $a, array $b): void
    {
        $this->values[0] = $a;
        $this->values[1] = $b;
    }

    public function first(): Object
    {
        reset($this->values);
        return $this;
    }

    public function last(): Object
    {
        next($this->values);
        return $this;
    }

    public function countRows(): int
    {
        return count($this->getCurrentValue());
    }

    public function countColumns(): int
    {
        $current = $this->getCurrentValue();
        if (!is_array(current($current))) {
            return 0;
        }

        return count(current($current));
    }

    public function result(): array
    {
        return $this->result;
    }

    public function getCurrentValue(): array
    {
        return current($this->values);
    }

    abstract function calculate(): Object;
}
