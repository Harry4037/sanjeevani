<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMealOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meal_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('invoice_id')->nullable();
            $table->string('resort_room_type')->nullable();
            $table->string('resort_room_no')->nullable();
            $table->string('invoice_id')->nullable();
            $table->bigInteger('resort_id')->default(0);
            $table->bigInteger('user_id')->default(0);
            $table->float('item_total_amount')->default(0);
            $table->float('gst_amount')->default(0);
            $table->float('total_amount')->default(0);
            $table->bigInteger('accepted_by')->default(0);
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('meal_orders');
    }
}
