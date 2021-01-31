<?php

namespace App\Services\Import\Fatura\Su\Adapters;

use App\Services\Import\Fatura\Adapters\AbstractImportedFaturaAdapter;

class ImportedFaturaAdapter extends AbstractImportedFaturaAdapter
{
    /**
     * @inheritDoc
     */
    public function getInvoicableArray()
    {
        $invoicableArray    = $this->getInvoicableArrayParent();

        return $invoicableArray;
    }
}
