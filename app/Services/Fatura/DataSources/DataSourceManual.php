<?php


namespace App\Services\Fatura\DataSources;


use App\Models\Fatura;

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

    /**
     * @inheritDoc
     */
    public function getTemplateHiddenFields(array $params): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getValidation(): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function runPostFaturaOperations(array $request, Fatura $fatura): void
    {

    }
}
