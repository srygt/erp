<?php


namespace App\Services\Fatura;


use App\Contracts\FaturaInterface;
use App\Exceptions\HizliTeknolojiIsSuccessException;
use App\Models\Abone;
use App\Models\Fatura;
use App\Models\FaturaTaslagi;
use App\Models\Mukellef;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Onrslu\HtEfatura\Models\CustomerIdentificationOther;
use Onrslu\HtEfatura\Models\Invoice;
use Onrslu\HtEfatura\Models\InvoiceHeader;
use Onrslu\HtEfatura\Models\InvoiceLines;
use Onrslu\HtEfatura\Models\InvoiceModel;
use Onrslu\HtEfatura\Models\Note;
use Onrslu\HtEfatura\Models\Party;
use Onrslu\HtEfatura\Services\RestRequest;
use Onrslu\HtEfatura\Types\Enums\AppType\EArsiv;
use Onrslu\HtEfatura\Types\Enums\AppType\EFatura;
use Onrslu\HtEfatura\Types\Enums\CurrencyCode;
use Onrslu\HtEfatura\Types\Enums\CustomerIdentificationSchemeId;
use Onrslu\HtEfatura\Types\Enums\InvoiceTypeCode\Satis;
use Onrslu\HtEfatura\Types\Enums\ProfileId\EArsivFatura;
use Onrslu\HtEfatura\Types\Enums\ProfileId\TicariFatura;
use Onrslu\HtEfatura\Types\Time;
use Throwable;

abstract class AbstractFatura
{
    /**
     * @param FaturaInterface $fatura
     * @param InvoiceLines $invoiceLines
     * @return Invoice
     * @throws Throwable
     */
    protected function createInvoice(FaturaInterface $fatura, InvoiceLines $invoiceLines)
    {
        $invoice = new Invoice();

        $customer = new Party();
        $customer
            ->setCountryName($fatura->abone->mukellef->{Mukellef::COLUMN_ULKE})
            ->setCityName($fatura->abone->mukellef->{Mukellef::COLUMN_IL})
            ->setCitySubdivisionName($fatura->abone->mukellef->{Mukellef::COLUMN_ILCE})
            ->setStreetName($fatura->abone->mukellef->{Mukellef::COLUMN_ADRES})
            ->setElectronicMail($fatura->abone->mukellef->{Mukellef::COLUMN_EMAIL})
            ->setPartyName($fatura->abone->mukellef->{Mukellef::COLUMN_UNVAN})
            ->setIdentificationID($fatura->abone->mukellef->getIdentificationId())
            ->setTaxSchemeName($fatura->abone->mukellef->{Mukellef::COLUMN_VERGI_DAIRESI})
            ->setTelephone($fatura->abone->getFormattedTelephone())
            ->setCustomerIdentificationsOther($this->getCustomerIdentificationOthers($fatura->abone));

        $customerAgent = new Party();
        $customerAgent
            ->setCountryName($fatura->abone->{Mukellef::COLUMN_ULKE})
            ->setCityName($fatura->abone->{Mukellef::COLUMN_IL})
            ->setCitySubdivisionName($fatura->abone->{Mukellef::COLUMN_ILCE})
            ->setStreetName($fatura->abone->{Mukellef::COLUMN_ADRES})
            ->setElectronicMail($fatura->abone->{Mukellef::COLUMN_EMAIL})
            ->setPartyName($fatura->abone->mukellef->{Mukellef::COLUMN_UNVAN})
            ->setIdentificationID($fatura->abone->mukellef->getIdentificationId())
            ->setTaxSchemeName($fatura->abone->mukellef->{Mukellef::COLUMN_VERGI_DAIRESI})
            ->setTelephone($fatura->abone->getFormattedTelephone())
            ->setCustomerIdentificationsOther($this->getCustomerIdentificationOthers($fatura->abone));

        $seller = new Party();
        $seller
            ->setCountryName(config('fatura.ulke'))
            ->setCityName(config('fatura.il'))
            ->setCitySubdivisionName(config('fatura.ilce'))
            ->setStreetName(config('fatura.adres'))
            ->setElectronicMail(config('fatura.email'))
            ->setPartyName(config('fatura.unvan'))
            ->setIdentificationID(config('fatura.vergiNo'))
            ->setTaxSchemeName(config('fatura.vergiDairesi'))
            ->setTelephone(config('fatura.telefon'));

        // Invoice Header
        $invoiceHeader = new InvoiceHeader();
        $invoiceHeader
            ->setDocumentCurrencyCode(new CurrencyCode('TRY'))
            ->setInvoiceTypeCode(new Satis())
            ->setInvoiceID(Fatura::getNextInvoiceId())
            ->setIssueDate($fatura->created_at->toDateString())
            ->setIssueTime(
                new Time(
                    $fatura->created_at->hour,
                    $fatura->created_at->minute,
                    $fatura->created_at->second
                )
            )
            ->setLineExtensionAmount($invoiceLines->getPriceTotalWithoutTaxes())
            ->setNote(
                new Note(
                    'Son Ödeme Tarihi: ' . $fatura->{Fatura::COLUMN_SON_ODEME_TARIHI}->toDateString()
                    . "\n"
                    . $fatura->{Fatura::COLUMN_NOT}
                    . "\n"
                )
            )
//            ->setNotes(new Notes([new Note('test')]))
            ->setOrderReferenceDate($fatura->created_at->toDateString())
            ->setOrderReferenceId($fatura->{Fatura::COLUMN_ID})
            ->setPayableAmount($invoiceLines->getPriceTotal())
            ->setProfileID(new EArsivFatura())
            ->setTaxInclusiveAmount($invoiceLines->getPriceTotal())
            ->setUUID($fatura->{Fatura::COLUMN_UUID});

        // Invoice Model
        $invoiceModel = new InvoiceModel();
        $invoiceModel
            ->setCustomer($customer)
            ->setCustomerAgent($customerAgent)
            ->setSupplier($seller)
            ->setInvoiceLines($invoiceLines)
            ->setInvoiceheader($invoiceHeader);

        $invoice
            ->setAppType(new EArsiv())
            ->setDestinationIdentifier($fatura->abone->mukellef->getIdentificationId())
            ->setDestinationUrn($fatura->abone->{Mukellef::COLUMN_URN})
            ->setSourceUrn(config('fatura.urn'))
            ->setInvoiceModel($invoiceModel);

        return $invoice;
    }

    /**
     * @param Abone $abone
     *
     * @return CustomerIdentificationOther[]
     */
    protected function getCustomerIdentificationOthers(Abone $abone): array
    {
        return [
            new CustomerIdentificationOther(
                new CustomerIdentificationSchemeId('ABONENO'),
                $abone->{Abone::COLUMN_ABONE_NO}
            ),
            new CustomerIdentificationOther(
                new CustomerIdentificationSchemeId('SAYACNO'),
                $abone->{Abone::COLUMN_SAYAC_NO}
            )
        ];
    }

    /**
     * @param FaturaInterface $fatura
     * @param Invoice $invoice
     * @param bool $isPreview
     * @return mixed
     * @throws GuzzleException
     * @throws Exception
     * @throws Throwable
     */
    protected function getResponse(FaturaInterface $fatura, Invoice $invoice, bool $isPreview)
    {

        $fatura     = $this->_updateRequestColumn($fatura, json_encode($invoice));

        try {
            $invoice        = $invoice->setIsPreview($isPreview);
            $response       = ((new RestRequest())->postSendInvoiceModel($invoice))
                ->getBody()
                ->getContents();

            $jsonResponse   = $this->_updateResponseColumn($fatura, $response);
        }
        catch (Exception $exception) {
            $fatura->{Fatura::COLUMN_HATA}      = $exception;
            $fatura->{Fatura::COLUMN_DURUM}     = Fatura::COLUMN_DURUM_HATA;

            $fatura->save();

            throw $exception;
        }

        $fatura->{Fatura::COLUMN_DURUM} = Fatura::COLUMN_DURUM_BASARILI;
        $fatura->save();

        return $jsonResponse;
    }

    /**
     * @param FaturaInterface|null $fatura
     * @param string $request
     *
     * @return FaturaInterface|null
     */
    protected function _updateRequestColumn(?FaturaInterface $fatura, string $request) : ?FaturaInterface
    {
        $fatura->{Fatura::COLUMN_ISTEK}         = $request;
        $fatura->save();

        return $fatura;
    }

    /**
     * @param FaturaInterface $fatura
     * @param string $response
     *
     * @return object
     * @throws Throwable
     */
    protected function _updateResponseColumn(FaturaInterface $fatura, string $response) : object
    {
        $fatura->{Fatura::COLUMN_CEVAP}     = $response;
        $fatura->save();

        $parsedResponse                     = json_decode($response);
        $isError                            = $parsedResponse[0]->IsSucceeded !== true;

        throw_if(
            $isError,
            new HizliTeknolojiIsSuccessException($parsedResponse[0]->Message)
        );

        return $parsedResponse[0];
    }

    /**
     * @param FaturaTaslagi $faturaTaslagi
     * @return mixed
     * @throws GuzzleException
     * @throws Throwable
     */
    public function getPreview(FaturaTaslagi $faturaTaslagi)
    {
        $invoice    = $this->getInvoice($faturaTaslagi);

        return $this->getResponse($faturaTaslagi, $invoice, true);
    }

    /**
     * @param Fatura $fatura
     * @return mixed
     * @throws Throwable
     * @throws GuzzleException
     */
    public function getBill(Fatura $fatura)
    {
        $invoice    = $this->getInvoice($fatura);

        return $this->getResponse($fatura, $invoice, false);
    }
}
