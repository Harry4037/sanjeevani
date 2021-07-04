<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimeZonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_zones', function (Blueprint $table) {
             $table->bigIncrements('id');
            $table->string('zone_name')->nullable();
            $table->string('time')->nullable();
            $table->string('time_difference')->nullable();
            $table->string('dst_time_zone_name')->nullable();
            $table->string('dst_start_date')->nullable();
            $table->tinyInteger('is_current_time_dst')->default(0);
            $table->string('dst_time_difference')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('time_zones');
    }
}
