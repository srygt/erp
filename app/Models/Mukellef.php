<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mukellef extends Model
{
    protected $table = 'mukellefler';
    public $timestamps = false;
    protected $primaryKey = 'MUKID';

    protected $guarded = ['MUKID'];

    public  function abone(){
        $this->belongsTo('App\Models\Abone','VKNTCKN');
    }

}
