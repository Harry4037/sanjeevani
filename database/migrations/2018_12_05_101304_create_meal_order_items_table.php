<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMealOrderItemsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('meal_order_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('meal_order_id')->default(1);
            $table->bigInteger('meal_item_id')->default(0);
            $table->tinyInteger('item_type')->default(0);
            $table->string('meal_item_name')->nullable();
            $table->integer('price')->default(0);
            $table->integer('quantity')->default(0);
            $table->tinyInteger('is_active')->default(1);
            $table->bigInteger('domain_id')->default(0);
            $table->string('created_by')->default(1);
            $table->string('updated_by')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('meal_order_items');
    }

}
