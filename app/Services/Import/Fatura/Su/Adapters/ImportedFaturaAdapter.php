<?php

namespace App\Services\Import\Fatura\Su\Adapters;

use App\Models\Ayar;
use App\Services\Import\Fatura\Adapters\AbstractImportedFaturaAdapter;

class ImportedFaturaAdapter extends AbstractImportedFaturaAdapter
{
    /**
     * @inheritDoc
     */
    public function getInvoicableArray()
    {
        $invoicableArray    = $this->getInvoicableArrayParent();

        if (!$invoicableArray['birim_fiyat']) {
            $invoicableArray['birim_fiyat'] = Ayar::where(
                Ayar::COLUMN_BASLIK,
                Ayar::FIELD_SU_TUKETIM_BIRIM_FIYAT
            )
                ->value(Ayar::COLUMN_DEGER);
        }

        return $invoicableArray;
    }
}
