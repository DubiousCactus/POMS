<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeSizeType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_item_topping', function (Blueprint $table) {
			$table->dropColumn('size');
			$table->integer('size_id')->unsigned()->nullable();
			$table->foreign('size_id')->references('id')->on('sizes');
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
			$table->dropForeign(['size_id']);
			$table->dropColumn('size');
			$table->string('size');
        });
    }
}
