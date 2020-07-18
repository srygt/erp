<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuFatura extends Model
{
    protected $table ='sufaturasi';
    public $timestamps=false;
    protected $primaryKey='SUFID';

    protected $guarded =[''];
}
