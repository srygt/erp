<?php

namespace App\Contracts;

interface ExcelImportRow
{
    public function __construct(array $array);
    public function toArray();
}
