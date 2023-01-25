<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodsReceiveDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_receive_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('goods_receive_id');
            $table->unsignedBigInteger('conversion_id');
            $table->string('item_name');
            $table->string('sku');
            $table->bigInteger('qty');
            $table->bigInteger('purchase_price');
            $table->timestamps();
            $table->foreign('goods_receive_id')->references('id')->on('goods_receives')->onDelete('cascade');
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
        Schema::dropIfExists('goods_receive_details');
    }
}
