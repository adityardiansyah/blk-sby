<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seller_id');
            $table->unsignedBigInteger('shop_id');
            $table->string('invoice');
            $table->date('trans_date');
            $table->enum('include_tax', ['YES','NO']);
            $table->integer('tax_persen');
            $table->integer('total_price');
            $table->integer('total_tax');
            $table->integer('total_disccount');
            $table->longText('notes');
            $table->foreign('seller_id')->references('id')->on('sellers')->onDelete('cascade');
            $table->foreign('shop_id')->references('id')->on('shop')->onDelete('cascade');
            $table->enum('status',['open','confirmed']);
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
        Schema::dropIfExists('sales');
    }
}
