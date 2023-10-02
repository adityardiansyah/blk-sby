<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdjusmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adjusments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('conversion_id');
            $table->string('type');
            $table->integer('qty');
            $table->text('notes');
            $table->string('status');
            $table->unsignedBigInteger('shop_id');
            $table->foreign('conversion_id')->references('id')->on('conversions')->onDelete('cascade');
            $table->foreign('shop_id')->references('id')->on('shop')->onDelete('cascade');
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
        Schema::dropIfExists('adjusments');
    }
}