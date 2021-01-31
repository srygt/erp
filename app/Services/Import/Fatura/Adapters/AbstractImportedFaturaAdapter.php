<?php


namespace App\Services\Import\Fatura\Adapters;


use App\Models\Ayar;
use App\Models\Fatura;
use App\Models\ImportedFatura;
use Illuminate\Support\Carbon;

abstract class AbstractImportedFaturaAdapter
{
    const FIELD_IMPORTED_ID = 'imported_id';

    /**
     * @var ImportedFatura $importedFatura Model
     */
    protected $importedFatura;

    /**
     * FormAdapter constructor.
     *
     * @param ImportedFatura $importedFatura Fatura
     */
    public function __construct(ImportedFatura $importedFatura)
    {
        $this->importedFatura = $importedFatura;
    }

    abstract public function getInvoicableArray();

    /**
     * Converts the given tree to inputs' name and value format.
     *
     * @param array|null $tree      Nested tree array.
     * @param string     $beginGlue Begin glue.
     * @param string     $endGlue   End glue.
     * @param int        $depth     Probably never will changed.
     *
     * @return array
     */
    public function toFormArray(array $tree = null, $beginGlue = '[', $endGlue = ']'
        , int $depth = 0
    ) {
        if (is_null($tree)) {
            $tree = $this->importedFatura;
        }

        $paths = [];

        foreach ($tree as $key => &$mixed) {
            $formattedKey = $depth > 0 ? ($beginGlue . $key . $endGlue) : $key;

            if (is_array($mixed)) {
                $results = $this->toFormArray(
                    $mixed, $beginGlue, $endGlue, $depth + 1
                );

                foreach ($results as $k => &$v) {

                    $paths[$formattedKey . $k] = $v;
                }

            } else {

                unset($results);

                $paths[$formattedKey] = $mixed;
            }
        }

        return $paths;
    }

    /**
     * @return array
     */
    protected function getInvoicableArrayParent() : array
    {
        $invoicableArray = [
            'tur' => $this->importedFatura->{ImportedFatura::COLUMN_TUR},
            'abone_id' => $this->importedFatura->{ImportedFatura::COLUMN_ABONE_ID},
            'fatura_tarih' => null,
            'son_odeme_tarihi' => null,
            'ilk_endeks' => $this->importedFatura
                ->{ImportedFatura::COLUMN_ENDEKS_ILK},
            'son_endeks' => $this->importedFatura
                ->{ImportedFatura::COLUMN_ENDEKS_SON},
            'birim_fiyat' => $this->importedFatura
                ->{ImportedFatura::COLUMN_BIRIM_FIYAT_TUKETIM},
            'not' => null,
            Fatura::COLUMN_DATA_SOURCE => Fatura::COLUMN_DATA_SOURCE_IMPORTED,
            self::FIELD_IMPORTED_ID => $this->importedFatura->id,
        ];

        $now = Carbon::now();

        $invoicableArray['fatura_tarih'] = $this->getFaturaTarih($now);

        $invoicableArray['son_odeme_tarihi'] = $this->getSonOdemeTarih($now);

        return $invoicableArray;
    }

    /**
     * @param Carbon $now Carbon
     *
     * @return mixed|string
     */
    protected function getFaturaTarih(Carbon $now)
    {
        // TODO: refactor
        return Ayar::where(
            Ayar::COLUMN_BASLIK,
            $this->importedFatura->{ImportedFatura::COLUMN_TUR}
            . '.fatura_tarih'
        )
            ->value(Ayar::COLUMN_DEGER);

        if (isset($this->importedFatura->{ImportedFatura::COLUMN_FATURA_TARIH})) {
            return $this->importedFatura->{ImportedFatura::COLUMN_FATURA_TARIH};
        }

        return $now->format(config('common.time.format'));
    }

    /**
     * @param Carbon $now Carbon
     *
     * @return mixed|string
     */
    protected function getSonOdemeTarih(Carbon $now)
    {
        if (isset($this->importedFatura->{ImportedFatura::COLUMN_SON_ODEME_TARIHI})) {
            return $this
                ->importedFatura
                ->{ImportedFatura::COLUMN_SON_ODEME_TARIHI}
                ->format(config('common.date.format'));
        }

        /**
         * @var string $faturaGun
         */
        $faturaGun = Ayar::where(
            Ayar::COLUMN_BASLIK,
            $this->importedFatura->{ImportedFatura::COLUMN_TUR}
            . '.son_odeme_gun'
        )
            ->value(Ayar::COLUMN_DEGER);

        $sonOdemeTarih = $now->setDay($faturaGun);

        if ($sonOdemeTarih->isPast()) {
            $sonOdemeTarih = $sonOdemeTarih->addMonth();
        }

        return $sonOdemeTarih->format(config('common.date.format'));
    }
}
