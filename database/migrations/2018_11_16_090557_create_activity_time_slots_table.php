<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityTimeSlotsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('activity_time_slots', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('amenity_id')->default(0);
            $table->time('from')->nullable();
            $table->time('to')->nullable();
            $table->integer('allow_no_of_member')->default(0);
            $table->tinyInteger('is_active')->default(1);
            $table->bigInteger('domain_id')->default(0);
            $table->string('created_by')->default(1);
            $table->string('updated_by')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('activity_time_slots');
    }

}
