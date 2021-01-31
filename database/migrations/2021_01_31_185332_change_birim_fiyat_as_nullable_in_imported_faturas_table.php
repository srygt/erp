<?php

use App\Models\ImportedFatura;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeBirimFiyatAsNullableInImportedFaturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('imported_faturas', function (Blueprint $table) {
            $table->decimal(
                ImportedFatura::COLUMN_BIRIM_FIYAT_TUKETIM,
                12,
                9
            )
                ->unsigned()
                ->nullable()
                ->change();
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
            $table->decimal(
                ImportedFatura::COLUMN_BIRIM_FIYAT_TUKETIM,
                12,
                9
            )
                ->unsigned()
                ->nullable(false)
                ->change();
        });
    }
}
