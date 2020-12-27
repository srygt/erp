<?php


namespace App\Services\Fatura\DataSources;


use App\Models\Fatura;

abstract class AbstractDataSource
{
    /**
     * Href of the back button in fatura preview page.
     *
     * @return string
     */
    abstract public function getHrefBackButton() : string;

    /**
     * Text of new invoice button in new fatura page.
     *
     * @return string
     */
    abstract public function getTextNewInvoiceButton() : string;

    /**
     * Href of new invoice button in new fatura page.
     *
     * @return string
     */
    abstract public function getHrefNewInvoiceButton() : string;

    /**
     * If there is hidden fields to send, set them in this function
     *
     * @param array $params
     *
     * @return array
     */
    abstract public function getTemplateHiddenFields(array $params) : array;

    /**
     * Specific validation rules of the data source
     *
     * @return array
     */
    abstract public function getValidation(): array;

    /**
     * The operations need to be run after successful process
     *
     * @param array $request
     * @param Fatura $fatura
     *
     * @return void
     */
    abstract public function runPostFaturaOperations(
        array $request, Fatura $fatura
    ): void;
}
