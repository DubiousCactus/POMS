<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrderIdToOrderItemTopping extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_item_topping', function (Blueprint $table) {
			$table->integer('order_id')->unsigned();
			$table->foreign('order_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_item_topping', function (Blueprint $table) {
			$table->dropForeign(['order_id']);
			$table->dropColumn('order_id');
        });
    }
}
