<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomBookingsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('room_bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('booking_id')->nullable(0);
            $table->bigInteger('room_type_id')->default(0);
            $table->bigInteger('resort_room_id')->default(0);
            $table->datetime('check_in')->nullable();
            $table->datetime('check_out')->nullable();
            $table->tinyInteger('is_active')->default(1);
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
        Schema::dropIfExists('room_bookings');
    }

}
