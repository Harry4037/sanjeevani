<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDesignationMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('designation_master', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('designation');
            $table->string('createdBy');
            $table->string('updatedBy');
            $table->tinyInteger('isActive');
            $table->bigInteger('domainId');
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
        Schema::dropIfExists('designation_master');
    }
}
