<?php


namespace App\Helpers;


use Exception;

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
     * @param null|string $invoiceId
     *
     * @return string
     */
    static public function getInvoiceId(?string $invoiceId)
    {
        $padLength = 9;
        $padString = '0';

        if ($invoiceId) {
            $id = (int) mb_substr($invoiceId, 7, mb_strlen($invoiceId) - 7);
            $id++;
        }
        else {
            $id = config('fatura.faturaNoStart');
        }

        return config('fatura.faturaNoPrefix') . date('Y')
            . str_pad($id, $padLength, $padString, STR_PAD_LEFT);
    }
}
