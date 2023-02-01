<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConversionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_master_id');
            $table->unsignedBigInteger('seller_id');
            $table->unsignedBigInteger('shop_id');
            $table->string('name_item');
            $table->string('sku');
            $table->integer('qty_final');
            $table->bigInteger('price')->nullable();
            $table->string('color')->nullable();
            $table->string('size')->nullable();
            $table->foreign('seller_id')->references('id')->on('sellers')->onDelete('cascade');
            $table->foreign('shop_id')->references('id')->on('shop')->onDelete('cascade');
            $table->foreign('product_master_id')->references('id')->on('product_masters')->onDelete('cascade');
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
        Schema::dropIfExists('conversions');
    }
}
