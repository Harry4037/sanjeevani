<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingpeopleAccompaniesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('bookingpeople_accompanies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('person_name')->nullable(0);
            $table->string('person_age')->nullable(0);
            $table->string('booking_id')->nullable();
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
        Schema::dropIfExists('bookingpeople_accompanies');
    }

}
