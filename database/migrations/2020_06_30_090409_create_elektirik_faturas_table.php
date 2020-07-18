<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateElektirikFaturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('elektrikfaturasi', function (Blueprint $table) {
            $table->increments('ELEKTRIKID');
            $table->integer("MUKELLEFID");
            $table->integer("ABONEID");
            $table->integer("SAYACID");
            $table->date("FATURATARIHI");
            $table->string("FATURANO",30);
            $table->string("FATURADONEMID",15);
            $table->date("ILKOKUMATARIHI");
            $table->date("SONOKUMATARIHI");
            $table->date("TEBLIGTARIHI");
            $table->date("SONODEMETARIHI");
            $table->decimal("ONCEKIDURUMBORCU",15,2);
            $table->decimal("SAYACBEDELI",15,0);
            $table->decimal("DAGITIMBEDELI",15,2);
            $table->decimal("SISTEMKULLANIMBEDELI",15,2);
            $table->decimal("PSHBEDELI",15,2);
            $table->timestamp("ISLEMTARIHI")->useCurrent();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('elektrikfaturasi');
    }
}
