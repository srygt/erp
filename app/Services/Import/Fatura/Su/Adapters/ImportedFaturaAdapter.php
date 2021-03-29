<?php

namespace App\Services\Import\Fatura\Su\Adapters;

use App\Models\Ayar;
use App\Services\Import\Fatura\Adapters\AbstractImportedFaturaAdapter;
use Exception;

class ImportedFaturaAdapter extends AbstractImportedFaturaAdapter
{
    /**
     * @inheritDoc
     */
    public function getInvoicableArray()
    {
        throw new Exception('TODO: handle sondaj and sebeke tuketim fields.');
        /*$invoicableArray    = $this->getInvoicableArrayParent();

        if (!$invoicableArray['birim_fiyat']) {
            $invoicableArray['birim_fiyat'] = Ayar::where(
                Ayar::COLUMN_BASLIK,
                Ayar::FIELD_SU_TUKETIM_BIRIM_FIYAT
            )
                ->value(Ayar::COLUMN_DEGER);
        }

        return $invoicableArray;*/
    }
}
