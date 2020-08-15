<?php

use App\Models\Abone;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAboneliklerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abonelikler', function (Blueprint $table) {
            $table->id();
            $table->enum(
                Abone::COLUMN_TUR,
                [
                    Abone::COLUMN_TUR_SU,
                    Abone::COLUMN_TUR_ELEKTRIK,
                    Abone::COLUMN_TUR_DOGALGAZ,
                ]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('abonelikler');
    }
}
