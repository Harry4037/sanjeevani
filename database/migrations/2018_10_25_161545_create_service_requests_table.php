<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceRequestsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('service_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('comment')->nullable();
            $table->text('questions')->nullable();
            $table->bigInteger('service_id')->default(0);
            $table->bigInteger('user_id')->default(0);
            $table->bigInteger('request_status_id')->default(0);
            $table->bigInteger('resort_id')->default(0);
            $table->string('room_type_name')->nullable();
            $table->string('resort_room_no')->nullable();
            $table->bigInteger('accepted_by_id')->default(0);
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
        Schema::dropIfExists('service_requests');
    }

}
