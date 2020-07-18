<?php


namespace App\Helpers\EfaturaXml\Definitions;


class Invoice
{
    public $UBLVersionID;
    public $CustomizationID;
    public $ProfileID;
    public $ID;
    public $CopyIndicator;
    public $UUID;
    public $IssueDate;
    public $IssueTime;
    public $InvoiceTypeCode;
    public $Note;
    public $DocumentCurrencyCode;
    public $LineCountNumeric;
    public $BillingReference;
    public $AdditionalDocumentReference;
    public $DespatchDocumentReference;
    public $Signature;
    public $AccountingSupplierParty;
    public $AccountingCustomerParty;
    public $AllowanceCharge;
    public $TaxTotal;
    public $LegalMonetaryTotal;
    public $BuyerCustomerParty;
    public $PaymentMeans;
    public $Delivery;
    public $PaymentTerms;
    public $OriginatorDocumentReference;
    public $PaymentAlternativeExchangeRate;
    public $InvoicePeriod;
    public $TaxRepresentativeParty;
    public $InvoiceLine;

}
