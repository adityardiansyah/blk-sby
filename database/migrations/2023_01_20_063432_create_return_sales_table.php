<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('return_sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seller_id');
            $table->unsignedBigInteger('shop_id');
            $table->unsignedBigInteger('conversion_id');
            $table->string('no_return');
            $table->date('date_return');
            $table->date('date_sale');
            $table->string('invoice');
            $table->string('item_name');
            $table->string('sku');
            $table->integer('qty');
            $table->string('unit');
            $table->bigInteger('unit_price');
            $table->bigInteger('bruto_price');
            $table->bigInteger('discount');
            $table->bigInteger('nett_total');
            $table->longText('notes');
            $table->timestamps();
            $table->foreign('seller_id')->references('id')->on('sellers')->onDelete('cascade');
            $table->foreign('shop_id')->references('id')->on('shop')->onDelete('cascade');
            $table->foreign('conversion_id')->references('id')->on('conversions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('return_sales');
    }
}
