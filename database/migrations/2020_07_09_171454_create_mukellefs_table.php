<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMukellefsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mukellefler', function (Blueprint $table) {
            $table->increments('MUKID');
            $table->char('VKNTCKN',11);
            $table->string("UNVAN");
            $table->string('AD')->nullable();
            $table->string('SOYAD')->nullable();
            $table->string('VERGIDAIRESISEHIR')->nullable();
            $table->string('VERGIDAIRESI')->nullable();
            $table->string('TICARETODASI')->nullable();
            $table->integer('MERSISNO')->nullable();
            $table->string('TICARETSICILNO')->nullable();
            $table->string('EPOSTA');
            $table->string('WEBSITE')->nullable();
            $table->string('ULKE');
            $table->string('IL');
            $table->string('ILCE');
            $table->integer('POSTAKODU')->nullable();
            $table->string('MAHALLECAD')->nullable();
            $table->string('BINAADI')->nullable();
            $table->string('BINANO')->nullable();
            $table->string('DAIRENO')->nullable();
            $table->integer('TELNO')->nullable();
            $table->string('FAKS')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mukellefler');
    }
}
