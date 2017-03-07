<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderItemToppingPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_item_topping', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('item_topping_id')->unsigned();
            $table->foreign('item_topping_id')->references('id')->on('item_topping');
            $table->integer('quantity')->default(1);
            $table->integer('size');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_item_topping');
    }
}
