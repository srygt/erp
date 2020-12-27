<?php

use App\Models\Fatura;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDataSourceFieldToFaturalarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fatura_taslaklari', function (Blueprint $table) {
            $table->enum(
                Fatura::COLUMN_DATA_SOURCE,
                Fatura::LIST_DATA_SOURCES
            )
                ->default(Fatura::COLUMN_DATA_SOURCE_MANUAL)
                ->index();
        });

        Schema::table('faturalar', function (Blueprint $table) {
            $table->enum(
                Fatura::COLUMN_DATA_SOURCE,
                Fatura::LIST_DATA_SOURCES
            )
                ->default(Fatura::COLUMN_DATA_SOURCE_MANUAL)
                ->index();
        });

        Schema::table('fatura_taslaklari', function (Blueprint $table) {
            $table->enum(
                Fatura::COLUMN_DATA_SOURCE,
                Fatura::LIST_DATA_SOURCES
            )
                ->default(null)
                ->change();
        });

        Schema::table('faturalar', function (Blueprint $table) {
            $table->enum(
                Fatura::COLUMN_DATA_SOURCE,
                Fatura::LIST_DATA_SOURCES
            )
                ->default(null)
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
        Schema::table('fatura_taslaklari', function (Blueprint $table) {
            $table->dropColumn([
                Fatura::COLUMN_DATA_SOURCE,
            ]);
        });

        Schema::table('faturalar', function (Blueprint $table) {
            $table->dropColumn([
                Fatura::COLUMN_DATA_SOURCE,
            ]);
        });
    }
}
