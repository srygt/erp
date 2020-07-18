<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aboneler', function (Blueprint $table) {
            $table->increments('ABONEID');
            $table->char("VKNTCKN",11);
            $table->tinyInteger("ABONETIPI");
            $table->integer("TARIFETIPI")->nullable();
            $table->integer("SAYACTIPI")->nullable();
            $table->boolean("ADURUMU");
            $table->timestamp("ATARIH");
            $table->string("IPNO",21)->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aboneler');
    }
}
