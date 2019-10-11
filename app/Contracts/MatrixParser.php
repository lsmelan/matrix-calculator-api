<?php
declare(strict_types=1);

namespace App\Contracts;

interface MatrixParser
{
    public function convert(array $rows): array;
}
