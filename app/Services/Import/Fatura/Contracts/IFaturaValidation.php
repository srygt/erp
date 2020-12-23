<?php


namespace App\Services\Import\Fatura\Contracts;


interface IFaturaValidation
{
    public function attributes() : array;
    public function rules() : array;
}
