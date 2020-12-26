<?php


namespace App\Services\Import\Fatura\Elektrik\Adapters;


use App\Models\Ayar;
use App\Models\AyarEkKalem;
use App\Models\ImportedFatura;
use App\Models\ImportedFaturaEkKalem;
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

        $invoicableArray['ek_kalemler'] = $this->getEkKalemFormArray();

        return $invoicableArray;
    }

    /**
     * @return array
     */
    public function getEkKalemFormArray()
    {
        $ekKalemler = $this->importedFatura
            ->ekKalemler()
            ->with(ImportedFaturaEkKalem::RELATION_EK_KALEM)
            ->get();

        $transformedEkKalemler = $ekKalemler->map(
            function ($pivot) {
                return [
                    'id' => $pivot->{ImportedFaturaEkKalem::COLUMN_EK_KALEM_ID},
                    'ucret_tur' => $pivot->{ImportedFaturaEkKalem::RELATION_EK_KALEM}
                        ->{AyarEkKalem::COLUMN_UCRET_TUR},
                    'deger' => $pivot->{ImportedFaturaEkKalem::COLUMN_DEGER},
                ];
            }
        );

        return [
            $this->importedFatura->{ImportedFatura::COLUMN_TUR}
                => $transformedEkKalemler->toArray(),
        ];
    }

    /**
     * @return null|string
     */
    protected function getNot() : ?string
    {
        if (isset($this->importedFatura->{ImportedFatura::COLUMN_NOT})) {
            return $this->importedFatura->{ImportedFatura::COLUMN_NOT};
        }

        return Ayar::wher(
            Ayar::COLUMN_BASLIK,
            $this->importedFatura->{ImportedFatura::COLUMN_TUR}
            . '.fatura_aciklama'
        )
            ->value(Ayar::COLUMN_DEGER);
    }
}
