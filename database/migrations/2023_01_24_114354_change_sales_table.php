<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->renameColumn('total_disccount','total_discount');
            $table->integer('total_disccount')->nullable()->change();
            $table->longText('notes')->nullable()->change();
        });

        Schema::table('detail_sales', function (Blueprint $table) {
            $table->integer('discount')->nullable()->change();
            $table->longText('notes')->nullable()->change();
        });

        Schema::table('return_sales', function (Blueprint $table) {
            $table->integer('discount')->nullable()->change();
            $table->longText('notes')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->integer('total_disccount');
            $table->longText('notes');
        });

        Schema::table('detail_sales', function (Blueprint $table) {
            $table->integer('discount');
            $table->bigInteger('notes');
        });

        Schema::table('return_sales', function (Blueprint $table) {
            $table->integer('discount');
            $table->longText('notes');
        });
    }
}
