<?php

use App\Models\ImportedFatura;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNotColumnAsNotlarInImportedFaturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('imported_faturas', function (Blueprint $table) {
            $table->renameColumn('not', 'notlar');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('imported_faturas', function (Blueprint $table) {
            $table->renameColumn('notlar', 'not');
        });
    }
}
