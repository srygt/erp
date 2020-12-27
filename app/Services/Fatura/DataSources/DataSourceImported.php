<?php


namespace App\Services\Fatura\DataSources;


use App\Models\Fatura;
use App\Models\ImportedFatura;
use App\Services\Import\Fatura\Adapters\AbstractImportedFaturaAdapter;

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

    /**
     * @inheritDoc
     */
    public function getTemplateHiddenFields(array $params): array
    {
        return [
            AbstractImportedFaturaAdapter::FIELD_IMPORTED_ID
                => $params['request'][AbstractImportedFaturaAdapter::FIELD_IMPORTED_ID],
        ];
    }

    /**
     * @inheritDoc
     */
    public function getValidation(): array
    {
        return [
            AbstractImportedFaturaAdapter::FIELD_IMPORTED_ID    => [
                'nullable',
                'exists:' . ImportedFatura::class . ',id'
            ],
        ];
    }

    /**
     * @inheritDoc
     */
    public function runPostFaturaOperations(array $request, Fatura $fatura): void
    {
        ImportedFatura::where(
                'id',
                $request[AbstractImportedFaturaAdapter::FIELD_IMPORTED_ID]
            )
            ->delete();
    }
}
