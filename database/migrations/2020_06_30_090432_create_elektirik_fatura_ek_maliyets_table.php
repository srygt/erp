<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateElektirikFaturaEkMaliyetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('elektrikfaturasiekmaliyetler', function (Blueprint $table) {
            $table->increments('EKMALID');
            $table->integer("ELFATURAID");
            $table->string("	EKMALIYETADI",75);
            $table->decimal("CARPANFARK",15,2);
            $table->decimal("EKMALIYETBEDELI",15,2);
            $table->decimal("TUKETIMFARK",15,2);
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
        Schema::dropIfExists('elektrikfaturasiekmaliyetler');
    }
}
