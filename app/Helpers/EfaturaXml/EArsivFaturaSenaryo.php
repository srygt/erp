<?php


namespace App\Helpers\EfaturaXml;

use App\Helpers\EfaturaXml\Definitions\AccountingSupplierParty;
use App\Helpers\EfaturaXml\Definitions\AdditionalDocumentReference;
use App\Helpers\EfaturaXml\Definitions\AdditionalItemIdentification;
use App\Helpers\EfaturaXml\Definitions\AllowanceCharge;
use App\Helpers\EfaturaXml\Definitions\Attachment;
use App\Helpers\EfaturaXml\Definitions\Contact;
use App\Helpers\EfaturaXml\Definitions\Country;
use App\Helpers\EfaturaXml\Definitions\CustomerParty;
use App\Helpers\EfaturaXml\Definitions\DigitalSignatureAttachment;
use App\Helpers\EfaturaXml\Definitions\ExternalReference;
use App\Helpers\EfaturaXml\Definitions\Invoice;
use App\Helpers\EfaturaXml\Definitions\InvoiceLine;
use App\Helpers\EfaturaXml\Definitions\Item;
use App\Helpers\EfaturaXml\Definitions\LegalMonetaryTotal;
use App\Helpers\EfaturaXml\Definitions\Party;
use App\Helpers\EfaturaXml\Definitions\PartyIdentification;
use App\Helpers\EfaturaXml\Definitions\PartyName;
use App\Helpers\EfaturaXml\Definitions\PartyTaxScheme;
use App\Helpers\EfaturaXml\Definitions\PostalAddress;
use App\Helpers\EfaturaXml\Definitions\Price;
use App\Helpers\EfaturaXml\Definitions\SignatoryParty;
use App\Helpers\EfaturaXml\Definitions\Signature;
use App\Helpers\EfaturaXml\Definitions\TaxCategory;
use App\Helpers\EfaturaXml\Definitions\TaxScheme;
use App\Helpers\EfaturaXml\Definitions\TaxSubtotal;
use App\Helpers\EfaturaXml\Definitions\TaxTotal;

class EArsivFaturaSenaryo

{
    private $invoiceSignature;
    private $invoice;
    private $invoiceSignatoryParty;
    private $invoiceSignaturePartyIdent;
    private $invoiceSignaturePartyPostal;
    private $invoiceSignaturePartyPostalCountry;
    private $invoiceSignatureDigital;
    private $invoiceSignatureDigitalExt;
    private $invoiceAdditinoalDocumentReference;
    private $invoiceAdditinoalDocumentReferenceAttachment;
    private $invoiceAccountingSupplierParty;
    private $SupplierPartyVknID;
    private $SupplierPartyMersisID;
    private $SupplierPartyPostalAdress;
    private $invoiceAccountingCustomerParty;
    private $invoiceAllowanceCharge;
    private $invoiceTaxTotal;
    private $invoiceTaxCategory;
    private $invoiceLine;
    private $invoiceLegalMonetaryTotal;
    private $invoiceLineTaxSubTotalCategory;
    private $invoiceLineItem;
    private $invoiceLineTaxSubTotal;
    private $invoiceLineAllowCharge;


    public function __construct()
    {
        $this->invoice = new Invoice();
        $this->invoiceSignature = new Signature();
        $this->invoiceSignatoryParty = new SignatoryParty();
        $this->invoiceSignaturePartyIdent = new PartyIdentification();
        $this->invoiceSignaturePartyPostal = new PostalAddress();
        $this->invoiceSignaturePartyPostalCountry = new Country();
        $this->invoiceSignatureDigital = new DigitalSignatureAttachment();
        $this->invoiceSignatureDigitalExt = new ExternalReference();
        $this->invoiceAdditinoalDocumentReference = new AdditionalDocumentReference();
        $this->invoiceAdditinoalDocumentReferenceAttachment = new Attachment();
        $this->invoiceAccountingSupplierParty = new AccountingSupplierParty();
        $this->invoiceAccountingSupplierParty->Party = new Party();
        $this->SupplierPartyMersisID = new PartyIdentification();
        $this->SupplierPartyVknID = new PartyIdentification();
        $this->invoiceAccountingSupplierParty->Party->PartyIdentification = $this->SupplierPartyMersisID;
        $this->invoiceAccountingSupplierParty->Party->PartyIdentification1 = $this->SupplierPartyVknID;
        $this->invoiceAccountingSupplierParty->Party->PartyName = new PartyName();
        $this->SupplierPartyPostalAdress= new PostalAddress();
        $this->invoiceAccountingSupplierParty->Party->PostalAddress = $this->SupplierPartyPostalAdress;
        $this->SupplierPartyPostalAdress->Country = new Country();
        $this->invoiceAccountingSupplierParty->Party->PartyTaxScheme=new PartyTaxScheme();
        $this->invoiceAccountingSupplierParty->Party->PartyTaxScheme->TaxScheme = new  TaxScheme();
        $this->invoiceAccountingSupplierParty->Party->Contact = new Contact();
        $this->invoice->AccountingSupplierParty = $this->invoiceAccountingSupplierParty;
        $this->invoiceAccountingCustomerParty = new CustomerParty();
        $this->invoice->AccountingCustomerParty = $this->invoiceAccountingCustomerParty;
        $this->invoiceAccountingCustomerParty->Party = new Party();
        $this->invoiceAccountingCustomerParty->Party->PartyName = new PartyName();
        $this->invoiceAccountingCustomerParty->Party->PartyIdentification = new PartyIdentification();
        $this->invoiceAccountingCustomerParty->Party->PostalAddress = new PostalAddress();
        $this->invoiceAccountingCustomerParty->Party->PostalAddress->Country = new Country();
        $this->invoiceAccountingCustomerParty->Party->PartyTaxScheme = new PartyTaxScheme();
        $this->invoiceAccountingCustomerParty->Party->PartyTaxScheme->TaxScheme = new TaxScheme();
        $this->invoiceAccountingCustomerParty->Party->Contact = new Contact();
        $this->invoiceAllowanceCharge = new AllowanceCharge();
        $this->invoice->AllowanceCharge = $this->invoiceAllowanceCharge;
        $this->invoiceTaxTotal = new TaxTotal();
        $this->invoice->TaxTotal = $this->invoiceTaxTotal;
        $this->invoiceTaxTotal->TaxSubtotal = new TaxSubtotal();
        $this->invoiceTaxCategory = new TaxCategory();
        $this->invoiceTaxTotal->TaxSubtotal->TaxCategory = $this->invoiceTaxCategory;
        $this->invoiceTaxCategory->TaxScheme = new TaxScheme();
        $this->invoiceLegalMonetaryTotal = new LegalMonetaryTotal();
        $this->invoice->LegalMonetaryTotal = $this->invoiceLegalMonetaryTotal;
        $this->invoiceLine = new InvoiceLine();
        $this->invoice->InvoiceLine = $this->invoiceLine;
        $this->invoiceLineAllowCharge = new AllowanceCharge();
        $this->invoiceLine->AllowanceCharge = $this->invoiceLineAllowCharge;
        $this->invoiceLine->TaxTotal = new TaxTotal();
        $this->invoiceLineTaxSubTotal = new TaxSubtotal();
        $this->invoiceLine->TaxTotal->TaxSubtotal =$this->invoiceLineTaxSubTotal;
        $this->invoiceLineTaxSubTotalCategory = new TaxCategory();
        $this->invoiceLineTaxSubTotal->TaxCategory = $this->invoiceLineTaxSubTotalCategory;
        $this->invoiceLineTaxSubTotalCategory->TaxScheme = new  TaxScheme();
        $this->invoiceLineItem = new Item();
        $this->invoiceLine->Item = $this->invoiceLineItem;
        $this->invoiceLineItem->AdditionalItemIdentification = new AdditionalItemIdentification();
        $this->invoiceLineItem->AdditionalItemIdentification1 = new AdditionalItemIdentification();
        $this->invoiceLineItem->AdditionalItemIdentification2 = new AdditionalItemIdentification();
        $this->invoiceLine->Price = new  Price();

    }

    /**
     * Xml
     */
    public function invoiceToXml()
    {
        $xml = new InoviceConvertXml($this->invoice);
        return $xml->getInvoiceResponseXML();
    }

    /** Invoice **/
    public function setInvoiceUBLVersionID($UBLVersionID)
    {
        $this->invoice->UBLVersionID = $UBLVersionID;
    }

    public function setInvoiceCustomizationID($CustomizationID)
    {
        $this->invoice->CustomizationID = $CustomizationID;
    }

    public function setInvoiceProfileID($ProfileID)
    {
        $this->invoice->ProfileID = $ProfileID;
    }

    public function setInvoiceID($ID)
    {
        $this->invoice->ID = $ID;
    }

    public function setInvoiceCopyIndicator($CopyIndicator)
    {
        $this->invoice->CopyIndicator = $CopyIndicator;
    }

    public function setInvoiceUUID($UUID)
    {
        $this->invoice->UUID = $UUID;
    }

    public function setInvoiceIssueDate($IssueDate)
    {
        $this->invoice->IssueDate = $IssueDate;
    }

    public function setInvoiceInvoiceTypeCode($TypeCode)
    {
        $this->invoice->InvoiceTypeCode = $TypeCode;
    }

    public function setInvoiceNote($Note)
    {
        $this->invoice->Note = $Note;
    }

    public function setInvoiceDocumentCurrencyCode($CurrencyCode)
    {
        $this->invoice->DocumentCurrencyCode = $CurrencyCode;
    }

    public function setInvoiceLineCountNumeric($LineCountNumeric)
    {
        $this->invoice->LineCountNumeric = $LineCountNumeric;
    }
    /** AdditionalDocumentReference **/
    /**
     * @param Attachment $invoiceAdditinoalDocumentReferenceAttachment
     */
    public function setInvoiceAdditinoalDocumentReferenceAttachment($filename, $value)
    {
        $this->invoiceAdditinoalDocumentReferenceAttachment->EmbeddedDocumentBinaryObject = ['val' => "$value", 'attrs' => ['mimeCode = "application/xml"', 'encodingCode = "Base64"',
            'characterSetCode = "UTF-8"', 'filename = "' . $filename . '"']];
        $this->invoiceAdditinoalDocumentReference->Attachment = $this->invoiceAdditinoalDocumentReferenceAttachment;
        $this->invoice->AdditionalDocumentReference = $this->invoiceAdditinoalDocumentReference;
    }


    /**
     * @param mixed $invoiceAdditinoalDocumentReference
     */
    public function setInvoiceAdditinoalDocumentReference($ID, $IssueDate, $DocumentType)
    {

        $this->invoiceAdditinoalDocumentReference->ID = $ID;
        $this->invoiceAdditinoalDocumentReference->IssueDate = $IssueDate;
        $this->invoiceAdditinoalDocumentReference->DocumentType = $DocumentType;


    }

    /** Signature Fonskiyonları */

    public function setInvoiceSignatureDigitalExt($Signature)

    {
        $this->invoiceSignatureDigitalExt->URI = $Signature;
        $this->invoiceSignatureDigital->ExternalReference = $this->invoiceSignatureDigitalExt;
        $this->invoiceSignature->DigitalSignatureAttachment = $this->invoiceSignatureDigital;
        $this->invoice->Signature = $this->invoiceSignature;
    }


    /**
     * @param Country $invoiceSignaturePartyPostalCountry
     */
    public function setInvoiceSignaturePartyPostalCountry($country)
    {
        $this->invoiceSignaturePartyPostalCountry->Name = $country;
        $this->invoiceSignaturePartyPostal->Country = $this->invoiceSignaturePartyPostalCountry;
        $this->invoiceSignatoryParty->PostalAddress = $this->invoiceSignaturePartyPostal;
        $this->invoiceSignature->SignatoryParty = $this->invoiceSignatoryParty;
    }


    /**
     * @param PostalAddress $invoiceSignaturePartyPostal
     */
    public function setInvoiceSignaturePartyPostal($streetName, $buildingName, $citySubdivisionName, $cityName, $postalZone, $Region, $Room,$buildingNumber)
    {
        $this->invoiceSignaturePartyPostal->StreetName = $streetName;
        $this->invoiceSignaturePartyPostal->BuildingName = $buildingName;
        $this->invoiceSignaturePartyPostal->BuildingNumber=$buildingNumber;
        $this->invoiceSignaturePartyPostal->CitySubdivisionName = $citySubdivisionName;
        $this->invoiceSignaturePartyPostal->CityName = $cityName;
        $this->invoiceSignaturePartyPostal->PostalZone = $postalZone;
        $this->invoiceSignaturePartyPostal->Region = $Region;
        $this->invoiceSignaturePartyPostal->Room = $Room;
    }

    /**
     * @param PartyIdentification $invoiceSignaturePartyIdent
     */
    public function setInvoiceSignaturePartyIdent($VKN)
    {
        $this->invoiceSignaturePartyIdent->ID = ['val' => "$VKN", 'attrs' => ['schemeID = "VKN"']];
        $this->invoiceSignatoryParty->PartyIdentification = $this->invoiceSignaturePartyIdent;
    }

    public function setSignatureID($VKN_TCKN)
    {
        $this->invoiceSignature->ID = ['val' => "$VKN_TCKN", 'attrs' => ['schemeID = "VKN_TCKN"']];

    }

    /** Acounting Supplier Party**/
    public function setInvoiceAccountingSupplierPartyURL($URL){
        $this->invoiceAccountingSupplierParty->Party->WebsiteURI = $URL;

    }
    public function setInvoiceAccountingSupplierPartyIDMersis($ID)
    {

        $this->SupplierPartyMersisID->ID = ['val' => "$ID", 'attrs' => ['schemeID="MERSISNO"']];
    }

    public function setInvoiceAccountingSupplierPartyIDVKN($ID)
    {
        $this->SupplierPartyVknID->ID = ['val' => "$ID", 'attrs' => ['schemeID="VKN"']];
    }

    public function setInvoiceAccountingSupplierPartyName($Name)
    {
        $this->invoiceAccountingSupplierParty->Party->PartyName->Name =$Name;
    }
  function setInvoiceAccountingSupplierPartyPostalAdress($streetName, $buildingName, $citySubdivisionName, $cityName, $postalZone, $Region, $Room,$buildingNumber)
    {
        $this->SupplierPartyPostalAdress->Room=$Room;
        $this->SupplierPartyPostalAdress->StreetName=$streetName;
        $this->SupplierPartyPostalAdress->BuildingName=$buildingName;
        $this->SupplierPartyPostalAdress->BuildingNumber=$buildingNumber;
        $this->SupplierPartyPostalAdress->CitySubdivisionName=$citySubdivisionName;
        $this->SupplierPartyPostalAdress->CityName=$cityName;
        $this->SupplierPartyPostalAdress->PostalZone=$postalZone;
        $this->SupplierPartyPostalAdress->Region=$Region;
    }
    public function setInvoiceAccountingSupplierPartyPostallAdressCountry($Country){
        $this->SupplierPartyPostalAdress->Country->Name=$Country;
    }
    public function setInvoiceAccountingSupplierPartyTaxScheme($TaxScheme){
        $this->invoiceAccountingSupplierParty->Party->PartyTaxScheme->TaxScheme->Name=$TaxScheme;
    }
    public function setInvoiceAccountingSupplierPartyContact($Telephone,$Telefax,$ElectronicMail){
        $this->invoiceAccountingSupplierParty->Party->Contact->Telephone = $Telephone;
        $this->invoiceAccountingSupplierParty->Party->Contact->Telefax=$Telefax;
        $this->invoiceAccountingSupplierParty->Party->Contact->ElectronicMail=$ElectronicMail;
    }
    /** Acounting Customer Party**/
    public function setInvoiceAccountingCustomerPartyURL($URL){
        $this->invoiceAccountingCustomerParty->Party->WebsiteURI=$URL;
    }
    public function setInvoiceAccountingCustomerPartyID($ID){
        $this->invoiceAccountingCustomerParty->Party->PartyIdentification->ID =['val' => "$ID", 'attrs' => ['schemeID="VKN"']];

    }
    public function setInvoiceAccountingCustomerPartyName($Name){
        $this->invoiceAccountingCustomerParty->Party->PartyName->Name = $Name;
    }
    public function setInvoiceAccountingCustomerPartyPostalAdress($streetName, $buildingName, $citySubdivisionName, $cityName, $postalZone, $Region, $Room,$buildingNumber){
        $this->invoiceAccountingCustomerParty->Party->PostalAddress->Room = $Room;
        $this->invoiceAccountingCustomerParty->Party->PostalAddress->StreetName = $streetName;
        $this->invoiceAccountingCustomerParty->Party->PostalAddress->BuildingName = $buildingName;
        $this->invoiceAccountingCustomerParty->Party->PostalAddress->BuildingNumber = $buildingNumber;
        $this->invoiceAccountingCustomerParty->Party->PostalAddress->CitySubdivisionName = $citySubdivisionName;
        $this->invoiceAccountingCustomerParty->Party->PostalAddress->CityName = $cityName;
        $this->invoiceAccountingCustomerParty->Party->PostalAddress->PostalZone = $postalZone;
        $this->invoiceAccountingCustomerParty->Party->PostalAddress->Region = $Region;
    }
    public function setInvoiceAccountingCustomerPartyPostalAdressCountry($Country){
        $this->invoiceAccountingCustomerParty->Party->PostalAddress->Country->Name = $Country;
    }
    public function setInvoiceAccountingCustomerPartyTaxScheme($TaxScheme){
        $this->invoiceAccountingCustomerParty->Party->PartyTaxScheme->TaxScheme->Name=$TaxScheme;
    }
    public function setInvoiceAccountingCustomerPartyContact($Telephone,$Telefax,$ElectronicMail){
        $this->invoiceAccountingCustomerParty->Party->Contact->Telephone = $Telephone;
        $this->invoiceAccountingCustomerParty->Party->Contact->Telefax=$Telefax;
        $this->invoiceAccountingCustomerParty->Party->Contact->ElectronicMail=$ElectronicMail;
    }
    /* Allowencharge **/
    public function  setInvoiceAllowanceChargeIndicator($chargeIndicator){
        $this->invoiceAllowanceCharge->ChargeIndicator = $chargeIndicator;

    }
    public function setInvoiceAllowanceChargeAmount($amount){
        $this->invoiceAllowanceCharge->Amount = ['val' => "$amount", 'attrs' => ['currencyID="TRY"']];
    }
    /*TaxTotal*/
    public function setInvoiceTaxTotalAmount($taxAmount){
        $this->invoiceTaxTotal->TaxAmount = ['val' => "$taxAmount", 'attrs' => ['currencyID="TRY"']];
    }
    public function setInvoiceTaxSubTotalTaxableAmount($taxableAmount){
        $this->invoiceTaxTotal->TaxSubtotal->TaxableAmount= ['val' => "$taxableAmount", 'attrs' => ['currencyID="TRY"']];
    }
    public function setInvoiceTaxSubTotalTaxAmount($amount){
        $this->invoiceTaxTotal->TaxSubtotal->TaxAmount =['val' => "$amount", 'attrs' => ['currencyID="TRY"']];
    }
    public function setInvoiceTaxSubTotalCalculationSequenceNumeric($num){
        $this->invoiceTaxTotal->TaxSubtotal->CalculationSequenceNumeric = $num;
    }
    public function setInvoiceTaxSubTotalPercent($percent){
        $this->invoiceTaxTotal->TaxSubtotal->Percent =$percent;
    }
    public function setInvoiceTaxSubTotalSchemeName($name){
        $this->invoiceTaxCategory->TaxScheme->Name = $name;

    }
    public function setInvoiceTaxSubTotalTypeCode($code){
        $this->invoiceTaxCategory->TaxScheme->TaxTypeCode = $code;

    }
    /* Legal Monetary Total **/
    public function setInvoiceLegalMonatryTotal($lineExtensionA,$taxExclusiveA,$taxInclusiveA,$AllowanceTotalAmount,$payableA){
        $this->invoiceLegalMonetaryTotal->LineExtensionAmount =['val' => "$lineExtensionA", 'attrs' => ['currencyID="TRY"']];
        $this->invoiceLegalMonetaryTotal->TaxExclusiveAmount = ['val' => "$taxExclusiveA", 'attrs' => ['currencyID="TRY"']];
        $this->invoiceLegalMonetaryTotal->TaxInclusiveAmount = ['val' => "$taxInclusiveA", 'attrs' => ['currencyID="TRY"']];
        $this->invoiceLegalMonetaryTotal->AllowanceTotalAmount =['val' => "$AllowanceTotalAmount", 'attrs' => ['currencyID="TRY"']];
        $this->invoiceLegalMonetaryTotal->PayableAmount = ['val' => "$payableA", 'attrs' => ['currencyID="TRY"']];
    }
    /* InvoiceLine **/

    public function setInvoiceLineID($ID){
        $this->invoiceLine->ID= $ID;
    }
    public function setInvoiceLineQuantity($Quantity){
        $this->invoiceLine->InvoicedQuantity = ['val' => "$Quantity", 'attrs' => ['unitCode="KGM"']];
    }
    public function setInvoiceLineExtensionAmount($amount){
        $this->invoiceLine->LineExtensionAmount =['val' => "$amount", 'attrs' => ['currencyID="TRY"']];
    }
    public function setInvoiceLineAllowCharge($ChargeIndicator,$AllowanceChargeReason,$MultiplierFactorNumeric,$Amount,$BaseAmount){
        $this->invoiceLineAllowCharge->ChargeIndicator=$ChargeIndicator;
        $this->invoiceLineAllowCharge->AllowanceChargeReason=$AllowanceChargeReason;
        $this->invoiceLineAllowCharge->Amount = ['val' => "$Amount", 'attrs' => ['currencyID="TRY"']];
        $this->invoiceLineAllowCharge->BaseAmount=['val' => "$BaseAmount", 'attrs' => ['currencyID="TRY"']];
        $this->invoiceLineAllowCharge->MultiplierFactorNumeric = $MultiplierFactorNumeric;
    }
    public function setInvoiceLineTaxAmount($taxAmount){
        $this->invoiceLine->TaxTotal->TaxAmount = ['val' => "$taxAmount", 'attrs' => ['currencyID="TRY"']];
    }
    public function setInvoiceLineTaxSubTotalcbc($TaxableAmount,$TaxAmount,$CalculationSequenceNumeric,$Percent){
        $this->invoiceLineTaxSubTotal->TaxableAmount =['val' => "$TaxableAmount", 'attrs' => ['currencyID="TRY"']];
        $this->invoiceLineTaxSubTotal->TaxAmount =['val' => "$TaxAmount", 'attrs' => ['currencyID="TRY"']];
        $this->invoiceLineTaxSubTotal->CalculationSequenceNumeric =$CalculationSequenceNumeric;
        $this->invoiceLineTaxSubTotal->Percent =$Percent;
    }
    public function setInvoiceLineTaxSubTotalCategory($name,$Code){
        $this->invoiceLineTaxSubTotal->TaxCategory->TaxScheme->Name =$name;
        $this->invoiceLineTaxSubTotal->TaxCategory->TaxScheme->TaxTypeCode=$Code;
    }
    public function setInvoiceLineItemName($name){
        $this->invoiceLineItem->Name =$name;
    }
    public function setInvoiceLineItemIdentification($ID1,$ID2,$ID3){
        $this->invoiceLineItem->AdditionalItemIdentification->ID = ['val' => "$ID1", 'attrs' => ['schemeID="KUNYENO"']];
        $this->invoiceLineItem->AdditionalItemIdentification1->ID = ['val' => "$ID2", 'attrs' => ['schemeID="MALSAHIBIADSOYADUNVAN"']];
        $this->invoiceLineItem->AdditionalItemIdentification2->ID = ['val' => "$ID3", 'attrs' => ['schemeID="MALSAHIBIVKNTCKN"']];
    }
    public function setInvoiceLinePriceAmount($amount){
        $this->invoiceLine->Price->PriceAmount =['val' => "$amount", 'attrs' => ['currencyID="TRY"']];
    }

}

