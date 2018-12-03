<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMealItemsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('meal_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('image_name')->nullable();
            $table->bigInteger('meal_type_id')->default(0);
            $table->enum('category', ['V', 'N']);
            $table->float('price')->default(0);
            $table->bigInteger('resort_id')->default(1);
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
        Schema::dropIfExists('meal_items');
    }

}
