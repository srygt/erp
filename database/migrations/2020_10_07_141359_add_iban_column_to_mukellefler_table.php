<?php

use App\Models\Mukellef;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIbanColumnToMukelleflerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mukellefler', function (Blueprint $table) {
            $table->string(Mukellef::COLUMN_IBAN)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mukellefler', function (Blueprint $table) {
            $table->dropColumn(Mukellef::COLUMN_IBAN);
        });
    }
}
