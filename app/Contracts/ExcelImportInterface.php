<?php

namespace App\Contracts;

interface ExcelImportInterface
{
    public function __construct(array $params);
    public function model(array $array);
    public function getCsvSettings(): array;
    public function startRow(): int;
    public function rules(): array;
    public function prepareForValidation($data, $index);
    public function customValidationAttributes();
}
