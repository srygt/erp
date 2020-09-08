<?php

/**
 * @param float $amount
 * @return string
 */
function getMoneyFormat(float $amount) : string
{
    return number_format($amount, 2, ',', '.');
}
