<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuFaturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sufaturasi', function (Blueprint $table) {
            $table->increments('SUFID');
            $table->string("ABONEID",11);
            $table->date("FATURATARIHI");
            $table->date("SONODEMETARIHI");
            $table->string("ILKENDEKS",25);
            $table->string("SONENDEKS",25);
            $table->string("TUKETIM",10);
            $table->decimal("FIYATI",15,3);
            $table->text("ACIKLAMA");


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sufaturasi');
    }
}
