<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAmenityRequestsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('amenity_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('amenity_id')->default(0);
            $table->bigInteger('user_id')->default(0);
            $table->bigInteger('accepted_by')->default(0);
            $table->Date('booking_date')->nullable();
            $table->time('from')->nullable();
            $table->time('to')->nullable();
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
        Schema::dropIfExists('amenity_requests');
    }

}
