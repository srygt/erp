<?php


namespace App\Services\Fatura\Dogalgaz;


use App\Contracts\FaturaInterface;
use App\Models\Abone;
use App\Models\Ayar;
use App\Models\Fatura;
use App\Services\Fatura\AbstractFatura;
use Illuminate\Support\Carbon;
use Onrslu\HtEfatura\Models\Invoice;
use Onrslu\HtEfatura\Models\InvoiceLine;
use Onrslu\HtEfatura\Models\InvoiceLines;
use Onrslu\HtEfatura\Models\LineTax;
use Onrslu\HtEfatura\Models\LineTaxes;
use Onrslu\HtEfatura\Models\PaymentMeans;
use Onrslu\HtEfatura\Types\Enums\QuantityUnitUser;
use Onrslu\HtEfatura\Types\Enums\TaxTypeCode;
use Onrslu\HtEfatura\Types\PriceModifiers\Percentage;
use Throwable;

class DogalgazFaturasiService extends AbstractFatura
{
    /**
     * @param FaturaInterface $faturaTaslagi
     * @param int[] $selectedEkKalemler
     * @return Invoice
     * @throws Throwable
     */
    protected function getInvoice(FaturaInterface $faturaTaslagi, array $selectedEkKalemler)
    {
        $values = [
            'tuketim'   =>
                $faturaTaslagi->{Fatura::COLUMN_ENDEKS_SON} - $faturaTaslagi->{Fatura::COLUMN_ENDEKS_ILK}, // Kwh, m3
            'bedel'     => [
                'birimFiyat'   => $faturaTaslagi->{Fatura::COLUMN_BIRIM_FIYAT_TUKETIM},
            ]
        ];

        $invoiceLineDogalgazTuketim   = $this->getDogalgazTuketim($values);
        $invoiceEkKalemler            = $this->getEkKalemler(
                                            $values['tuketim'],
                                            Abone::COLUMN_TUR_DOGALGAZ,
                                            $selectedEkKalemler,
                                            new QuantityUnitUser('KWH')
                                        );

        $invoiceKalemler              = array_merge([$invoiceLineDogalgazTuketim], $invoiceEkKalemler);

        // Invoice Lines
        $invoiceLines = new InvoiceLines($invoiceKalemler);

        $invoice = parent::createInvoice($faturaTaslagi, $invoiceLines);

        return $invoice;
    }

    /**
     * @param $values
     * @return InvoiceLine
     * @throws Throwable
     */
    protected function getDogalgazTuketim($values)
    {
        $invoiceLine = new InvoiceLine();
        $invoiceLine
            ->setId(1)
            ->setItemName('Doğalgaz Tüketim Bedeli')
            ->setPriceAmount($values['bedel']['birimFiyat'])
            ->setQuantityAmount($values['tuketim'])
            ->setQuantityUnitUser(new QuantityUnitUser('KWH'));

        $taxOtv = (new LineTax())
            ->setTax(
                new Percentage(0.0157, $invoiceLine->getPriceTotalWithoutTaxes())
            )
            ->setTaxCode(new TaxTypeCode(TaxTypeCode::OTV_1_LISTE))
            ->setTaxName('ÖTV 1. LİSTE');

        $taxKdv = (new LineTax())
                ->setTax(
                    new Percentage(
                        $this->getKdvPercentage(),
                        $invoiceLine->getPriceTotalWithoutTaxes()
                            + $taxOtv->getTaxAmnt()
                    )
                )
                ->setTaxCode(new TaxTypeCode(TaxTypeCode::KDV_GERCEK))
                ->setTaxName('KDV');

        $lineTaxes = new LineTaxes([
            $taxOtv,
            $taxKdv,
        ]);

        $invoiceLine->setLineTaxes($lineTaxes);

        return $invoiceLine;
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

        return $note;
    }

    /**
     * @return float
     */
    protected function getKdvPercentage(): float
    {
        return 0.18;
    }

    /**
     * @param Carbon $paymentDueDate
     * @return PaymentMeans
     */
    protected function getPaymentMeans(Carbon $paymentDueDate) : PaymentMeans
    {
        return parent::generatePaymentMeans(
            $paymentDueDate,
            Ayar::where(Ayar::COLUMN_BASLIK, Ayar::FIELD_DOGALGAZ_BANKA_IBAN)
                ->value(Ayar::COLUMN_DEGER)
        );
    }
}
