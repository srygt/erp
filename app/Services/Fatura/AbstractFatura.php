<?php


namespace App\Services\Fatura;


use App\Adapters\AyarEkKalemAdapter;
use App\Contracts\FaturaInterface;
use App\Events\FaturaCreated;
use App\Exceptions\HizliTeknolojiIsSuccessException;
use App\Exceptions\UnsupportedAppTypeException;
use App\Helpers\Utils;
use App\Models\Abone;
use App\Models\Ayar;
use App\Models\AyarEkKalem;
use App\Models\Fatura;
use App\Models\FaturaTaslagi;
use App\Models\Mukellef;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Carbon;
use Illuminate\View\View;
use Onrslu\HtEfatura\Contracts\AppType;
use Onrslu\HtEfatura\Models\CustomerIdentificationOther;
use Onrslu\HtEfatura\Models\Invoice;
use Onrslu\HtEfatura\Models\InvoiceHeader;
use Onrslu\HtEfatura\Models\InvoiceLine;
use Onrslu\HtEfatura\Models\InvoiceLines;
use Onrslu\HtEfatura\Models\InvoiceModel;
use Onrslu\HtEfatura\Models\LineTax;
use Onrslu\HtEfatura\Models\LineTaxes;
use Onrslu\HtEfatura\Models\Note;
use Onrslu\HtEfatura\Models\Party;
use Onrslu\HtEfatura\Models\PaymentMeans;
use Onrslu\HtEfatura\Services\RestRequest;
use Onrslu\HtEfatura\Types\Enums\AppType\EArsiv;
use Onrslu\HtEfatura\Types\Enums\AppType\EFatura;
use Onrslu\HtEfatura\Types\Enums\CurrencyCode;
use Onrslu\HtEfatura\Types\Enums\CustomerIdentificationSchemeId;
use Onrslu\HtEfatura\Types\Enums\InvoiceTypeCode\Satis;
use Onrslu\HtEfatura\Types\Enums\ProfileId\EArsivFatura;
use Onrslu\HtEfatura\Types\Enums\ProfileId\TicariFatura;
use Onrslu\HtEfatura\Types\Enums\QuantityUnitUser;
use Onrslu\HtEfatura\Types\Enums\TargetCode;
use Onrslu\HtEfatura\Types\Enums\TaxTypeCode;
use Onrslu\HtEfatura\Types\PriceModifiers\Percentage;
use Onrslu\HtEfatura\Types\Time;
use Throwable;

abstract class AbstractFatura
{
    /**
     * @param FaturaInterface $fatura
     * @return string
     */
    abstract protected function getAboneAndSayacNotes(FaturaInterface $fatura) : string;

    /**
     * @return float
     */
    abstract protected function getKdvPercentage() : float;

    /**
     * @param Carbon $paymentDueDate
     * @return PaymentMeans
     */
    abstract protected function getPaymentMeans(Carbon $paymentDueDate) : PaymentMeans;

    /**
     * @param array $params
     * @return View
     */
    abstract public static function getRedirectToPayPage(array $params): View;

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
            ->setPartyName($fatura->abone->mukellef->{Mukellef::COLUMN_UNVAN})
            ->setPersonFirstName($fatura->abone->mukellef->{Mukellef::COLUMN_AD})
            ->setPersonFamilyName($fatura->abone->mukellef->{Mukellef::COLUMN_SOYAD})
            ->setIdentificationID($fatura->abone->mukellef->getIdentificationId())
            ->setTaxSchemeName($fatura->abone->mukellef->{Mukellef::COLUMN_VERGI_DAIRESI})
            ->setTelephone($fatura->abone->mukellef->{Mukellef::COLUMN_TELEFON})
            ->setCustomerIdentificationsOther($this->getCustomerIdentificationOthers($fatura->abone));

        if (config('fatura.emailActive')) {
            $customer->setElectronicMail($fatura->abone->mukellef->{Mukellef::COLUMN_EMAIL});
        }

        $customerAgent = new Party();
        $customerAgent
            ->setCountryName($fatura->abone->{Mukellef::COLUMN_ULKE})
            ->setCityName($fatura->abone->{Mukellef::COLUMN_IL})
            ->setCitySubdivisionName($fatura->abone->{Mukellef::COLUMN_ILCE})
            ->setStreetName($fatura->abone->{Mukellef::COLUMN_ADRES})
            ->setPartyName($fatura->abone->mukellef->{Mukellef::COLUMN_UNVAN})
            ->setPersonFirstName($fatura->abone->mukellef->{Mukellef::COLUMN_AD})
            ->setPersonFamilyName($fatura->abone->mukellef->{Mukellef::COLUMN_SOYAD})
            ->setIdentificationID($fatura->abone->mukellef->getIdentificationId())
            ->setTaxSchemeName($fatura->abone->mukellef->{Mukellef::COLUMN_VERGI_DAIRESI})
            ->setTelephone($fatura->abone->{Mukellef::COLUMN_TELEFON})
            ->setCustomerIdentificationsOther($this->getCustomerIdentificationOthers($fatura->abone));

        if (config('fatura.emailActive')) {
            $customerAgent->setElectronicMail($fatura->abone->{Mukellef::COLUMN_EMAIL});
        }

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
            ->setIssueDate($fatura->{Fatura::COLUMN_FATURA_TARIH}->toDateString())
            ->setIssueTime(
                new Time(
                    $fatura->{Fatura::COLUMN_FATURA_TARIH}->hour,
                    $fatura->{Fatura::COLUMN_FATURA_TARIH}->minute,
                    $fatura->{Fatura::COLUMN_FATURA_TARIH}->second
                )
            )
            ->setLineExtensionAmount($invoiceLines->getPriceTotalWithoutTaxes())
            ->setNote(
                new Note(
                    $this->getAboneAndSayacNotes($fatura)
                    . 'Son Ödeme Tarihi: ' . $fatura->{Fatura::COLUMN_SON_ODEME_TARIHI}->format('d.m.Y') . "\n\n"
                    . 'Banka Hesap Adı: ' . Ayar::where(Ayar::COLUMN_BASLIK, $fatura->{Fatura::COLUMN_TUR} . '.banka_hesap_adi')
                                                ->first()->{Ayar::COLUMN_DEGER} . "\n\n"
                    . $fatura->{Fatura::COLUMN_NOT}
                    . "\n\n"
                )
            )
//            ->setNotes(new Notes([new Note('test')]))
            ->setOrderReferenceDate($fatura->{Fatura::COLUMN_FATURA_TARIH}->toDateString())
            ->setOrderReferenceId($fatura->{Fatura::COLUMN_ID})
            ->setPayableAmount($invoiceLines->getPriceTotal())
            ->setTaxInclusiveAmount($invoiceLines->getPriceTotal())
            ->setUUID($fatura->{Fatura::COLUMN_UUID});

        // Payment Means
        $paymentMeans = $this->getPaymentMeans(
                            $fatura->{Fatura::COLUMN_SON_ODEME_TARIHI}
                                ->hour(23)
                                ->minute(59)
                                ->second(59)
                        );

        // Invoice Model
        $invoiceModel = new InvoiceModel();
        $invoiceModel
            ->setCustomer($customer)
            ->setCustomerAgent($customerAgent)
            ->setSupplier($seller)
            ->setInvoiceLines($invoiceLines)
            ->setInvoiceheader($invoiceHeader)
            ->setPaymentMeans([$paymentMeans]);

        $invoice
            ->setDestinationIdentifier($fatura->abone->mukellef->getIdentificationId())
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
        $identifications = [];

        if ($abone->{Abone::COLUMN_ABONE_NO})
        {
            $identifications[]  = new CustomerIdentificationOther(
                    new CustomerIdentificationSchemeId('ABONENO'),
                    $abone->{Abone::COLUMN_ABONE_NO}
                );
        }

        if ($abone->{Abone::COLUMN_SAYAC_NO})
        {
            $identifications[]  = new CustomerIdentificationOther(
                    new CustomerIdentificationSchemeId('SAYACNO'),
                    $abone->{Abone::COLUMN_SAYAC_NO}
                );
        }

        return $identifications;
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

        $fatura     = $this->_updateDBBeforeRequest($fatura, $invoice);

        $invoice        = $invoice->setIsPreview($isPreview);
        $response       = ((new RestRequest())->postSendInvoiceModel($invoice))
            ->getBody()
            ->getContents();

        $jsonResponse   = $this->_updateDBAfterRequest($fatura, $response);

        return $jsonResponse;
    }

    /**
     * @param FaturaInterface|null $fatura
     * @param Invoice $invoice
     * @return FaturaInterface|null
     */
    protected function _updateDBBeforeRequest(?FaturaInterface $fatura, Invoice $invoice) : ?FaturaInterface
    {
        FaturaLog::save('fatura.logPaths.request', $fatura, json_encode($invoice));

        $fatura->{Fatura::COLUMN_APP_TYPE}              = (string)($invoice->getAppType());
        $fatura->{Fatura::COLUMN_TOPLAM_ODENECEK_UCRET} = $invoice->getInvoiceModel()
                                                            ->getInvoiceheader()
                                                            ->getPayableAmount();
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
    protected function _updateDBAfterRequest(FaturaInterface $fatura, string $response) : object
    {
        FaturaLog::save('fatura.logPaths.response', $fatura, $response);

        $parsedResponse                     = json_decode($response);
        $isError                            = $parsedResponse[0]->IsSucceeded !== true;

        throw_if(
            $isError,
            new HizliTeknolojiIsSuccessException($parsedResponse[0]->Message)
        );

        $fatura->{Fatura::COLUMN_DURUM} = Fatura::COLUMN_DURUM_BASARILI;
        $fatura->save();

        FaturaCreated::dispatch($fatura);

        return $parsedResponse[0];
    }

    /**
     * @param Invoice $invoice
     * @param FaturaInterface $fatura
     * @return Invoice
     * @throws GuzzleException
     * @throws Throwable
     * @throws UnsupportedAppTypeException
     */
    protected function setTargetType(Invoice $invoice, FaturaInterface $fatura) : Invoice
    {
        $restRequest = new RestRequest();

        $efaturaUrn  = $restRequest->getAvailableUrn(
                new EFatura(),
                new TargetCode(TargetCode::RECEIVER),
                $invoice->getInvoiceModel()->getCustomerAgent()->getIdentificationID(),
                $fatura->abone->{Mukellef::COLUMN_URN}
            );

        if ($efaturaUrn) {
            $invoiceId  = self::getNextInvoiceId(new EFatura());

            $invoice->setAppType(new EFatura());
            $invoice->getInvoiceModel()->getInvoiceheader()->setProfileID(new TicariFatura());
            $invoice->setDestinationUrn($efaturaUrn);
        }
        else {
            $invoiceId  = self::getNextInvoiceId(new EArsiv());

            $invoice->setAppType(new EArsiv());
            $invoice->getInvoiceModel()->getInvoiceheader()->setProfileID(new EArsivFatura());
        }

        $invoice->getInvoiceModel()->getInvoiceheader()->setInvoiceID($invoiceId);

        if ( get_class($fatura) === Fatura::class )
        {
            $fatura->{Fatura::COLUMN_INVOICE_ID}    = $invoiceId;
            $fatura->save();
        }

        return $invoice;
    }

    /**
     * @param float $tuketimMiktari
     * @param string $tur
     * @param array $selectedEkKalemler
     * @param QuantityUnitUser $quantityType
     * @return array
     * @throws Throwable
     */
    protected function getEkKalemler(float $tuketimMiktari, string $tur,
                                     array $selectedEkKalemler, QuantityUnitUser $quantityType) : array
    {
        $invoiceLines       = [];
        $selectedEkKalemler = collect($selectedEkKalemler)
            ->sortBy('id')
            ->values();

        $ekKalemler = AyarEkKalem::where(AyarEkKalem::COLUMN_TUR, $tur)
            ->whereIn('id', $selectedEkKalemler->pluck('id'))
            ->orderBy('id')
            ->get();

        if ($ekKalemler->count() < 1) {
            return [];
        }

        foreach ($ekKalemler as $no => $ekKalem) {
            $ekKalemAdapter = new AyarEkKalemAdapter(
                                    $ekKalem,
                                    $tuketimMiktari,
                                    $selectedEkKalemler[$no]['deger'],
                                    $quantityType
                                );

            $invoiceLine = new InvoiceLine();
            $invoiceLine
                ->setId($no + 2)
                ->setItemName($ekKalemAdapter->getBaslik())
                ->setPriceAmount($ekKalemAdapter->getUcret())
                ->setQuantityAmount($ekKalemAdapter->getMiktar())
                ->setQuantityUnitUser($ekKalemAdapter->getMiktarTuru());

            $taxKdv = (new LineTax())
                ->setTax(new Percentage($this->getKdvPercentage(), $invoiceLine->getPriceTotalWithoutTaxes()))
                ->setTaxCode(new TaxTypeCode(TaxTypeCode::KDV_GERCEK))
                ->setTaxName('KDV');

            $taxes = new LineTaxes([
                $taxKdv,
            ]);

            $invoiceLine->setLineTaxes($taxes);

            $invoiceLines[] = $invoiceLine;
        }

        return $invoiceLines;
    }

    /**
     * @param Carbon $paymentDueDate
     * @param string $bankAccount
     * @return PaymentMeans
     */
    protected function generatePaymentMeans(Carbon $paymentDueDate, string $bankAccount): PaymentMeans
    {
        $paymentMeans = new PaymentMeans();

        $paymentMeans->setInstructionNote('-');
        $paymentMeans->setPayeeFinancialAccount($bankAccount);
        $paymentMeans->setPayeeFinancialCurrencyCode(new CurrencyCode('TRY'));
        $paymentMeans->setPaymentChannelCode('');
        $paymentMeans->setPaymentDueDate($paymentDueDate->toDateTimeString());
        $paymentMeans->setPaymentMeansCode('ZZZ');

        return $paymentMeans;
    }

    /**
     * @param Throwable $e
     * @param FaturaInterface $fatura
     */
    protected static function logError(Throwable $e, FaturaInterface $fatura)
    {
        FaturaLog::save('fatura.logPaths.error', $fatura, $e);

        $fatura->{Fatura::COLUMN_DURUM} = Fatura::COLUMN_DURUM_HATA;
        $fatura->save();
    }

    /**
     * @param AppType $appType
     * @return string
     * @throws GuzzleException
     * @throws HizliTeknolojiIsSuccessException
     * @throws UnsupportedAppTypeException
     */
    public static function getNextInvoiceId(AppType $appType) : string
    {
        $response   = (new RestRequest())
                        ->getLastInvoiceIdAndDate(
                            $appType,
                            Utils::getFaturaConfig($appType)['prefix'] . config('fatura.eXNoDatePrefix')
                        )
                        ->getBody()
                        ->getContents();

        $response   = json_decode($response);

        if (!($response->IsSucceeded ?? false)) {
            throw new HizliTeknolojiIsSuccessException($response->Message);
        }

        return Utils::getInvoiceId($response->InvoiceId);
    }

    /**
     * @param FaturaTaslagi $faturaTaslagi
     * @param array $selectedEkKalemler
     * @return mixed
     * @throws GuzzleException
     * @throws Throwable
     */
    public function getPreview(FaturaTaslagi $faturaTaslagi, array $selectedEkKalemler)
    {
        try
        {
            $invoice    = $this->getInvoice($faturaTaslagi, $selectedEkKalemler);
            $invoice    = $this->setTargetType($invoice, $faturaTaslagi);

            return $this->getResponse($faturaTaslagi, $invoice, true);
        }
        catch (Throwable $e)
        {
            self::logError($e, $faturaTaslagi);
            throw $e;
        }
    }

    /**
     * @param Fatura $fatura
     * @param array $selectedEkKalemler
     * @return mixed
     * @throws Throwable
     * @throws GuzzleException
     */
    public function getBill(Fatura $fatura, array $selectedEkKalemler)
    {
        try
        {
            $invoice    = $this->getInvoice($fatura, $selectedEkKalemler);
            $invoice    = $this->setTargetType($invoice, $fatura);

            return $this->getResponse($fatura, $invoice, false);
        }
        catch (Throwable $e)
        {
            self::logError($e, $fatura);
            throw $e;
        }
    }
}
