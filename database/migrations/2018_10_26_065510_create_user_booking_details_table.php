<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserBookingDetailsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('user_booking_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('source_name')->nullable(0);
            $table->string('source_id')->nullable(0);
            $table->bigInteger('user_id')->default(0);
            $table->bigInteger('resort_id')->default(0);
            $table->bigInteger('package_id')->default(0);
            $table->bigInteger('room_type_id')->default(0);
            $table->string('room_type_name')->nullable();
            $table->bigInteger('resort_room_id')->default(0);
            $table->string('resort_room_no')->nullable();
            $table->datetime('check_in')->nullable();
            $table->integer('check_in_pin')->nullable();
            $table->tinyInteger('is_verified_check_in_pin')->default(0);
            $table->datetime('check_out')->nullable();
            $table->integer('check_out_pin')->nullable();
            $table->tinyInteger('is_verified_check_out_pin')->default(0);
            $table->tinyInteger('is_active')->default(1);
            $table->tinyInteger('is_cancelled')->default(0);
            $table->bigInteger('domain_id')->default(0);
            $table->string('created_by')->default(0);
            $table->string('updated_by')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('user_booking_details');
    }

}
