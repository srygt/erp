<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ElektirikFaturaEndeks extends Model
{
    protected $table ='elektirikfaturasiendeksleri';
    public $timestamps=false;
    protected $primaryKey='EFEID';

    protected $guarded =[];
}
