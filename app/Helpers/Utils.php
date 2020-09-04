<?php


namespace App\Helpers;


use App\Exceptions\UnsupportedAppTypeException;
use Exception;
use Onrslu\HtEfatura\Types\Enums\AppType\BaseAppType;
use Onrslu\HtEfatura\Types\Enums\AppType\EArsiv;
use Onrslu\HtEfatura\Types\Enums\AppType\EFatura;

class Utils
{
    /**
     * @param string $rawPhoneNumber E.g. 905554443322
     *
     * @return string
     * @throws Exception
     */
    static public function getFormattedTelephoneNumber(string $rawPhoneNumber)
    {
        $rawPhoneNumber = preg_replace('~\D~', '', $rawPhoneNumber);

        if (mb_strlen($rawPhoneNumber) === 10) {
            $rawPhoneNumber = '90' . $rawPhoneNumber;
        }

        if (mb_strlen($rawPhoneNumber) === 11) {
            $rawPhoneNumber = '9' . $rawPhoneNumber;
        }

        if (mb_strlen($rawPhoneNumber) !== 12) {
            throw new Exception('Phone number must be consist of 12 digits!');
        }

        return (
            mb_substr($rawPhoneNumber, 0, 2)
            . ' '
            . mb_substr($rawPhoneNumber, 2, 3)
            . ' '
            . mb_substr($rawPhoneNumber, 5, 3)
            . ' '
            . mb_substr($rawPhoneNumber, 8, 2)
            . ' '
            . mb_substr($rawPhoneNumber, 10, 2)
        );
    }

    /**
     * @param BaseAppType $appType
     * @param null|string $invoiceId
     *
     * @return string
     * @throws UnsupportedAppTypeException
     */
    static public function getInvoiceId(BaseAppType $appType, ?string $invoiceId)
    {
        $padLength = 9;
        $padString = '0';

        if ($invoiceId) {
            $id = (int) mb_substr($invoiceId, 7, mb_strlen($invoiceId) - 7);
            $id++;
        }
        else {
            $id = Utils::getFaturaConfig($appType)['start'];
        }

        return Utils::getFaturaConfig($appType)['prefix'] . date('Y')
            . str_pad($id, $padLength, $padString, STR_PAD_LEFT);
    }

    /**
     * @param string|null $aboneNo
     * @return string|null
     */
    static public function getFormattedAboneNo(?string $aboneNo) : ?string
    {
        if (!$aboneNo) {
            return null;
        }

        return str_pad(
            $aboneNo,
            config('fatura.aboneNoPadLength'),
            config('fatura.aboneNoPadString'),
            config('fatura.aboneNoPadDirection')
        );
    }

    /**
     * @param string|null $value
     * @return string|null
     */
    static public function getFloatValue(?string $value) : ?string
    {
        if (!$value) {
            return null;
        }

        return preg_replace('~[^0-9.]~', '', $value);
    }

    /**
     * @param BaseAppType $appType
     * @return array
     * @throws UnsupportedAppTypeException
     */
    static public function getFaturaConfig(BaseAppType $appType)
    {
        if ( (string)($appType) === (string)(new EFatura) )
        {
            return [
                'prefix'   => config('fatura.eFaturaNoPrefix'),
                'start'    => config('fatura.eFaturaNoStart'),
            ];
        }
        else if ( (string)($appType) === (string)(new EArsiv()) )
        {
            return [
                'prefix'   => config('fatura.eArsivNoPrefix'),
                'start'    => config('fatura.eArsivNoStart'),
            ];
        }

        throw new UnsupportedAppTypeException('The given "app_type" isn\'t supported!');

    }
}
