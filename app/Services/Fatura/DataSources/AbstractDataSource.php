<?php


namespace App\Services\Fatura\DataSources;


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


}
