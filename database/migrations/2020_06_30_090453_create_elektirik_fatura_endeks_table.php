<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateElektirikFaturaEndeksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('elektrikfaturasiendeksleri', function (Blueprint $table) {
            $table->increments('EFEID');
            $table->integer("ELFATURAID");
            $table->string("ENDEKSKONUSU",50);
            $table->decimal("ILKENDEKS",15,3);
            $table->decimal("SONENDEKS",15,3);
            $table->decimal("CARPAN",15,3);
            $table->decimal("TUKETIM",15,3);
            $table->decimal("AETUKETIM",15,3);
            $table->decimal("EKTUKETIM",15,3);
            $table->decimal("TOPLAMTUKETIM",15,3);
            $table->decimal("BIRIMFIYAT",15,3);
            $table->decimal("BEDELI",15,3);
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
        Schema::dropIfExists('elektrikfaturasiendeksleri');
    }
}
