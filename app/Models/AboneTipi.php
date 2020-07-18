<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboneTipi extends Model
{
    protected $table ='abonetipi';
    public $timestamps= false;
    protected $primaryKey='ATID';

    protected $guarded =[];
}
