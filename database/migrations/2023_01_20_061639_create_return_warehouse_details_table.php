<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnWarehouseDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('return_warehouse_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('return_warehouse_id');
            $table->unsignedBigInteger('conversion_id');
            $table->string('item_name');
            $table->string('sku');
            $table->integer('qty');
            $table->bigInteger('purchase_price');
            $table->enum('status',['open','confirmed']);
            $table->foreign('return_warehouse_id')->references('id')->on('return_warehouses')->onDelete('cascade');
            $table->foreign('conversion_id')->references('id')->on('conversions')->onDelete('cascade');
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
        Schema::dropIfExists('return_warehouse_details');
    }
}
