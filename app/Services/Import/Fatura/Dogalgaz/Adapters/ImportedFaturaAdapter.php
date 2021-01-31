<?php

namespace App\Services\Import\Fatura\Dogalgaz\Adapters;

use App\Services\Import\Fatura\Adapters\AbstractImportedFaturaAdapter;

class ImportedFaturaAdapter extends AbstractImportedFaturaAdapter
{
    /**
     * @return array
     */
    public function getInvoicableArray() : array
    {
        $invoicableArray    = $this->getInvoicableArrayParent();

        $invoicableArray['ek_kalemler'] = $this->getEkKalemFormArray();

        return $invoicableArray;
    }
}
