<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMealPackageItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meal_package_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('meal_package_id')->default(1);
            $table->bigInteger('meal_item_id')->default(1);
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
    public function down()
    {
        Schema::dropIfExists('meal_package_items');
    }
}
