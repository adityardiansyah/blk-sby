<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTableReturnWarehouse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('return_warehouses', function (Blueprint $table) {
            $table->string('file_attachment')->nullable()->change();
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
        Schema::table('return_warehouses', function (Blueprint $table) {
            $table->string('file_attachment');
            $table->longText('notes');
        });
    }
}
