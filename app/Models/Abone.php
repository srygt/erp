<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Abone extends Model
{
    protected $table = 'aboneler';
    protected $dateFormat = 'Y-m-d H:i:s';
    public $timestamps = false;
    protected $primaryKey = 'ABONEID ';
    protected $guarded = ['ABONEID'];

    public function Mukellef(){
        return $this->hasOne('App\Models\Mukellef','VKNTCKN','VKNTCKN');
    }
}
