<?php


namespace App\Services\Fatura\DataSources;


class DataSourceImported extends AbstractDataSource
{

    /**
     * @inheritDoc
     */
    public function getHrefBackButton(): string
    {
        return 'javascript:window.history.go(-2)';
    }

    /**
     * @inheritDoc
     */
    public function getTextNewInvoiceButton(): string
    {
        return 'Fatura Taslaklarını Listele';
    }

    /**
     * @inheritDoc
     */
    public function getHrefNewInvoiceButton(): string
    {
        return route('import.fatura.liste');
    }
}
