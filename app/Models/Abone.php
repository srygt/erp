<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Abone extends Model
{
    protected $table = 'abonelikler';
    protected $dateFormat = 'Y-m-d H:i:s';

    const COLUMN_TUR = 'tur';
    const COLUMN_TUR_SU = 'su';
    const COLUMN_TUR_ELEKTRIK = 'elektrik';
    const COLUMN_TUR_DOGALGAZ = 'dogalgaz';

    public function mukellef(){
        return $this->belongsTo(Mukellef::class,'mukellef_id','id');
    }
}
