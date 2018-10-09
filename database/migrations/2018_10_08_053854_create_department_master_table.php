<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('department_master', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('department');
            $table->bigInteger('parentId');
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
        Schema::dropIfExists('department_master');
    }
}
