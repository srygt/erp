<?php

namespace App\Services\Import\Fatura\Su\Adapters;

use App\Models\Abone;
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
        $invoicableArray    = $this->getInvoicableArrayParent();

        if (!$invoicableArray['birim_fiyat']) {

            /** @var Abone $abone */
            $abone = Abone::find($invoicableArray['abone_id']);

            if ($abone->{Abone::COLUMN_SONDAJ_MI}) {
                $birimFiyatAyarBaslik = Ayar::FIELD_SU_SONDAJ_TUKETIM_BIRIM_FIYAT;
            }
            else {
                $birimFiyatAyarBaslik = Ayar::FIELD_SU_SEBEKE_TUKETIM_BIRIM_FIYAT;
            }

            $invoicableArray['birim_fiyat'] = Ayar::where(
                Ayar::COLUMN_BASLIK,
                $birimFiyatAyarBaslik
            )
                ->value(Ayar::COLUMN_DEGER);
        }

        return $invoicableArray;
    }
}
