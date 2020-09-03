<?php


namespace App\Services\Fatura\Elektrik;


use App\Contracts\FaturaInterface;
use App\Models\Abone;
use App\Models\Fatura;
use App\Services\Fatura\AbstractFatura;
use Onrslu\HtEfatura\Models\Invoice;
use Onrslu\HtEfatura\Models\InvoiceLine;
use Onrslu\HtEfatura\Models\InvoiceLines;
use Onrslu\HtEfatura\Models\LineTax;
use Onrslu\HtEfatura\Models\LineTaxes;
use Onrslu\HtEfatura\Types\Enums\QuantityUnitUser;
use Onrslu\HtEfatura\Types\Enums\TaxTypeCode;
use Onrslu\HtEfatura\Types\PriceModifiers\Percentage;
use Throwable;

class ElektrikFaturasiService extends AbstractFatura
{
    /**
     * @param FaturaInterface $fatura
     * @param int[] $selectedEkKalemler
     * @return Invoice
     * @throws Throwable
     */
    protected function getInvoice(FaturaInterface $fatura, array $selectedEkKalemler)
    {
        $values = [
            'tuketim'   =>
                $fatura->{Fatura::COLUMN_ENDEKS_SON} - $fatura->{Fatura::COLUMN_ENDEKS_ILK}, // Kwh, m3
            'bedel'     => [
                'elektrikTuketim'   => $fatura->{Fatura::COLUMN_BIRIM_FIYAT_TUKETIM},
            ]
        ];

        $invoiceKalemElektrikTuketim        = $this->getElektrikTuketim($fatura, $values);
        $invoiceEkKalemler                   = $this->getEkKalemler(
                                                $values['tuketim'],
                                                Abone::COLUMN_TUR_ELEKTRIK,
                                                $selectedEkKalemler,
                                                new QuantityUnitUser('KWH')
                                                );
        $invoiceKalemler                    = array_merge([$invoiceKalemElektrikTuketim], $invoiceEkKalemler);

        // Invoice Lines
        $invoiceLines = new InvoiceLines($invoiceKalemler);

        $invoice = parent::createInvoice($fatura, $invoiceLines);

        return $invoice;
    }

    /**
     * @param FaturaInterface $fatura
     * @param $values
     * @return InvoiceLine
     * @throws Throwable
     */
    protected function getElektrikTuketim(FaturaInterface $fatura, $values)
    {
        // Elektrik Tüketim Bedeli
        $invoiceLineElektrikTuketim = new InvoiceLine();
        $invoiceLineElektrikTuketim
            ->setId(1)
            ->setItemName('Elektrik Tüketim Bedeli')
            ->setPriceAmount($values['bedel']['elektrikTuketim'])
            ->setQuantityAmount($values['tuketim'])
            ->setQuantityUnitUser(new QuantityUnitUser('KWH'));

        $taxTrt = (new LineTax())
            ->setTax(
                new Percentage(0.02, $invoiceLineElektrikTuketim->getPriceTotalWithoutTaxes())
            )
            ->setTaxCode(new TaxTypeCode(TaxTypeCode::TRT_PAYI))
            ->setTaxName('TRT Payı');

        $taxEnergy = (new LineTax())
            ->setTax(
                new Percentage(0.01, $invoiceLineElektrikTuketim->getPriceTotalWithoutTaxes())
            )
            ->setTaxCode(new TaxTypeCode(TaxTypeCode::ENERJI_FONU))
            ->setTaxName('Enerji Fonu');

        $taxKdv = (new LineTax())
            ->setTax(
                new Percentage(
                    $this->getKdvPercentage(),
                    $invoiceLineElektrikTuketim->getPriceTotalWithoutTaxes()
                        + $taxEnergy->getTaxAmnt()
                        + $taxTrt->getTaxAmnt()
                )
            )
            ->setTaxCode(new TaxTypeCode(TaxTypeCode::KDV_GERCEK))
            ->setTaxName('KDV');

        $lineTaxes  = [];

        if ($fatura->abone->{Abone::COLUMN_TRT_PAYI}) {
            $lineTaxes[] = $taxTrt;
        }

        $lineTaxes  = array_merge($lineTaxes, [
            $taxEnergy,
            $taxKdv,
        ]);

        $elektrikTuketimTaxes = new LineTaxes($lineTaxes);

        $invoiceLineElektrikTuketim->setLineTaxes($elektrikTuketimTaxes);

        return $invoiceLineElektrikTuketim;
    }

    /**
     * @param FaturaInterface $fatura
     * @return string
     */
    protected function getAboneAndSayacNotes(FaturaInterface $fatura) : string
    {
        $note = '';

        if ($fatura->abone->{Abone::COLUMN_ABONE_NO})
        {
            $note   .= 'Abone No: ' . $fatura->abone->{Abone::COLUMN_ABONE_NO} . "\n";
        }

        if ($fatura->abone->{Abone::COLUMN_SAYAC_NO} )
        {
            $note   .= 'Sayaç No: ' . $fatura->abone->{Abone::COLUMN_SAYAC_NO} . "\n";
        }

        return $note;
    }

    /**
     * @return float
     */
    protected function getKdvPercentage(): float
    {
        return 0.18;
    }
}
