<?php


namespace App\Services\Fatura\Su;


use App\Contracts\FaturaInterface;
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

class SuFaturasiService extends AbstractFatura
{
    /**
     * @param FaturaInterface $faturaTaslagi
     * @return Invoice
     * @throws Throwable
     */
    protected function getInvoice(FaturaInterface $faturaTaslagi)
    {
        $values = [
            'tuketim'   =>
                $faturaTaslagi->{Fatura::COLUMN_ENDEKS_SON} - $faturaTaslagi->{Fatura::COLUMN_ENDEKS_ILK}, // Kwh, m3
            'bedel'     => [
                'birimFiyat'   => $faturaTaslagi->{Fatura::COLUMN_BIRIM_FIYAT_TUKETIM},
            ]
        ];

        $invoiceLine         = $this->getSuTuketim($values);

        // Invoice Lines
        $invoiceLines = new InvoiceLines([
            $invoiceLine,
        ]);

        $invoice = parent::createInvoice($faturaTaslagi, $invoiceLines);

        return $invoice;
    }

    /**
     * @param $values
     * @return InvoiceLine
     * @throws Throwable
     */
    protected function getSuTuketim($values)
    {
        $invoiceLine = new InvoiceLine();
        $invoiceLine
            ->setId(1)
            ->setItemName('Su Tüketim Bedeli')
            ->setPriceAmount($values['bedel']['birimFiyat'])
            ->setQuantityAmount($values['tuketim'])
            ->setQuantityUnitUser(new QuantityUnitUser('MTQ'));

        $lineTaxes = new LineTaxes([
            (new LineTax())
                ->setTax(new Percentage(0.18, $invoiceLine->getPriceTotalWithoutTaxes()))
                ->setTaxCode(new TaxTypeCode(TaxTypeCode::KDV_GERCEK))
                ->setTaxName('KDV')
        ]);

        $invoiceLine->setLineTaxes($lineTaxes);

        return $invoiceLine;
    }
}
