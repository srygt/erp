<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboneTur extends Model
{
    protected $table ='aboneturleri';
    public $timestamps=false;
    protected $primaryKey='ATID';

    protected $guarded =[];
}
