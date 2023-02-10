<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileGoodsReceivedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_goods_receives', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('goods_receive_id');
            $table->string('filename');
            $table->foreign('goods_receive_id')->references('id')->on('goods_receives')->onDelete('cascade');
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
        Schema::dropIfExists('file_goods_receives');
    }
}
