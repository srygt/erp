<?php


namespace App\Services\Fatura\DataSources;


class DataSourceManual extends AbstractDataSource
{

    /**
     * @inheritDoc
     */
    public function getHrefBackButton(): string
    {
        return 'window.history.back()';
    }

    /**
     * @inheritDoc
     */
    public function getTextNewInvoiceButton(): string
    {
        return 'Yeni Fatura Oluştur';
    }

    /**
     * @inheritDoc
     */
    public function getHrefNewInvoiceButton(): string
    {
        return route('faturataslak.ekle.get');
    }
}
