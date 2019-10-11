<?php
declare(strict_types=1);

namespace App\Models;

use App\Contracts\MatrixParser;
use App\Exceptions\InvalidMatrixException;

class MatrixMultiplication extends MatrixCalculator
{
    private $parser;

    public function __construct(MatrixParser $parser)
    {
        $this->parser = $parser;
        parent::__construct();
    }

    public function calculate(): Object
    {
        $rowsA = $this->first()->countRows();
        $columnsA = $this->countColumns();
        $matrixA = $this->getCurrentValue();

        $rowsB = $this->last()->countRows();
        $columnsB = $this->countColumns();
        $matrixB = $this->getCurrentValue();

        if ($rowsB != $columnsA) {
            throw new InvalidMatrixException("Matrices not valid for multiplication");
        }

        for ($i = 0; $i < $rowsA; $i++) {
            for ($j = 0; $j < $columnsB; $j++) {
                $this->result[$i][$j] = 0;
                for ($k = 0; $k < $rowsB; $k++) {
                    $this->result[$i][$j] += ($matrixA[$i][$k] ?? 0) * ($matrixB[$k][$j] ?? 0);
                }
            }
        }

        return $this;
    }

    public function result(): array
    {
        return $this->parser->convert(parent::result());
    }
}
