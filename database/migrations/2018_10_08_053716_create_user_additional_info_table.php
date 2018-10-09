<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAdditionalInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_additional_info', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('uderId');
            $table->string('encryptionKey');
            $table->string('password');
            $table->string('createdBy');
            $table->string('updatedBy');
            $table->tinyInteger('iaActive');
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
        Schema::dropIfExists('user_additional_info');
    }
}
