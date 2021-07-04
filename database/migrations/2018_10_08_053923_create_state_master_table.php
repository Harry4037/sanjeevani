<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStateMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('state_master', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('state')->nullable();
            $table->bigInteger('countryId')->nullable();
            $table->string('createdBy')->default(0);
            $table->string('updatedBy')->default(0);
            $table->tinyInteger('isActive')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('state_master');
    }
}
