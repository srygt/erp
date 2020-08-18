<?php


namespace App\Contracts;

use App\Models\Abone;
use Carbon\Carbon;

/**
 * Interface FaturaInterface
 * @package App\Contracts
 *
 * @property Abone $abone
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 *
 * @method save()
 */
interface FaturaInterface
{
    public function abone();
}
