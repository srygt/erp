<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSayacsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sayaclar', function (Blueprint $table) {
            $table->increments('SAYACID');
            $table->integer("MUKID");
            $table->integer("ABONETURU");
            $table->string("SAYACNO",25);
            $table->boolean("DURUMU");


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sayaclar');
    }
}
