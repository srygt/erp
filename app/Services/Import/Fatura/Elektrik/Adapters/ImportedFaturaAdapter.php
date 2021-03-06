<?php

namespace App\Services\Import\Fatura\Elektrik\Adapters;

use App\Models\Ayar;
use App\Models\Fatura;
use App\Models\ImportedFatura;
use App\Models\ImportedFaturaElektrik;
use App\Services\Import\Fatura\Adapters\AbstractImportedFaturaAdapter;

class ImportedFaturaAdapter extends AbstractImportedFaturaAdapter
{
    /**
     * @return array
     */
    public function getInvoicableArray() : array
    {
        $invoicableArray    = $this->getInvoicableArrayParent();

        $invoicableArray    = $this->setGunduzPuandGeceTuketim($invoicableArray);
        $invoicableArray    = $this->setEnduktif($invoicableArray);
        $invoicableArray    = $this->setKapasitif($invoicableArray);

        $invoicableArray['ek_kalemler'] = $this->getEkKalemFormArray();

        return $invoicableArray;
    }

    /**
     * @param array $invoicableArray
     *
     * @return array
     */
    protected function setEnduktif(array $invoicableArray) : array
    {
        $enduktifTuketim    = $this->importedFatura
            ->elektrik
            ->{ImportedFaturaElektrik::COLUMN_ENDUKTIF_TUKETIM};

        $enduktifBirimFiyat = $this->importedFatura
            ->elektrik
            ->{ImportedFaturaElektrik::COLUMN_ENDUKTIF_BIRIM_FIYAT};

        if (0.0 < $enduktifBirimFiyat) {
            $invoicableArray['enduktif_tuketim']        = $enduktifTuketim;
            $invoicableArray['enduktif_birim_fiyat']    = $enduktifBirimFiyat;
        }

        return $invoicableArray;
    }

    /**
     * @param array $invoicableArray
     *
     * @return array
     */
    protected function setKapasitif(array $invoicableArray) : array
    {
        $kapasitifTuketim    = $this->importedFatura
            ->elektrik
            ->{ImportedFaturaElektrik::COLUMN_KAPASITIF_TUKETIM};

        $kapasitifBirimFiyat = $this->importedFatura
            ->elektrik
            ->{ImportedFaturaElektrik::COLUMN_KAPASITIF_BIRIM_FIYAT};

        if (0.0 < $kapasitifBirimFiyat) {
            $invoicableArray['kapasitif_tuketim'] = $kapasitifTuketim;
            $invoicableArray['kapasitif_birim_fiyat'] = $kapasitifBirimFiyat;
        }

        return $invoicableArray;
    }

    /**
     * @param array $invoicableArray
     *
     * @return array
     */
    protected function setGunduzPuandGeceTuketim(array $invoicableArray) : array
    {
        $invoicableArray[Fatura::COLUMN_GUNDUZ_TUKETIM] = $this->importedFatura
            ->elektrik
            ->{ImportedFaturaElektrik::COLUMN_GUNDUZ_TUKETIM};

        $invoicableArray[Fatura::COLUMN_PUAND_TUKETIM] = $this->importedFatura
            ->elektrik
            ->{ImportedFaturaElektrik::COLUMN_PUAND_TUKETIM};

        $invoicableArray[Fatura::COLUMN_GECE_TUKETIM] = $this->importedFatura
            ->elektrik
            ->{ImportedFaturaElektrik::COLUMN_GECE_TUKETIM};

        return $invoicableArray;
    }

    /**
     * @return null|string
     */
    protected function getNot() : ?string
    {
        if (isset($this->importedFatura->{ImportedFatura::COLUMN_NOT})) {
            return $this->importedFatura->{ImportedFatura::COLUMN_NOT};
        }

        return Ayar::where(
            Ayar::COLUMN_BASLIK,
            $this->importedFatura->{ImportedFatura::COLUMN_TUR}
            . '.fatura_aciklama'
        )
            ->value(Ayar::COLUMN_DEGER);
    }
}
