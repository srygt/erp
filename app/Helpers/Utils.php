<?php


namespace App\Helpers;


use App\Exceptions\UnsupportedAppTypeException;
use Exception;
use Onrslu\HtEfatura\Contracts\AppType;
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
     * @param string $previousInvoiceId
     *
     * @return string
     */
    static public function getInvoiceId(string $previousInvoiceId)
    {
        $prefix     = mb_substr($previousInvoiceId, 0, 3);
        $id         = (int) mb_substr($previousInvoiceId, 7, mb_strlen($previousInvoiceId) - 7);
        $nextId     = $id + 1;

        $padLength  = 9;
        $padString  = '0';

        return $prefix . date('Y') . str_pad($nextId, $padLength, $padString, STR_PAD_LEFT);
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
     * @param AppType $appType
     * @return array
     * @throws UnsupportedAppTypeException
     */
    static public function getFaturaConfig(AppType $appType)
    {
        if ( (string)($appType) === (string)(new EFatura) )
        {
            return [
                'prefix'   => config('fatura.eFaturaNoPrefix'),
            ];
        }
        else if ( (string)($appType) === (string)(new EArsiv()) )
        {
            return [
                'prefix'   => config('fatura.eArsivNoPrefix'),
            ];
        }

        throw new UnsupportedAppTypeException('The given "app_type" isn\'t supported!');

    }
}
