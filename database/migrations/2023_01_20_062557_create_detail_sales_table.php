<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sales_id');
            $table->unsignedBigInteger('conversion_id');
            $table->string('item_name');
            $table->string('sku');
            $table->integer('qty');
            $table->string('unit');
            $table->bigInteger('unit_price');
            $table->bigInteger('bruto_price');
            $table->bigInteger('discount');
            $table->bigInteger('nett_total');
            $table->bigInteger('notes');
            $table->enum('status',['finished','return']);
            $table->foreign('sales_id')->references('id')->on('sales')->onDelete('cascade');
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
        Schema::dropIfExists('detail_sales');
    }
}
