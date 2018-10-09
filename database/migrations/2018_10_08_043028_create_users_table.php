<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('salutationId');
            $table->string('firstName');
            $table->string('lastName');
            $table->string('midName');
            $table->enum('gender', ['M', 'F']);
            $table->string('emailId');
            $table->string('alternateEmailId');
            $table->string('ScreenName');
            $table->dateTime('dateOfJoining');
            $table->dateTime('dateOfBirth');
            $table->string('profilePicPath');
            $table->integer('mobileNumber');
            $table->string('otherContactNumber');
            $table->string('address1');
            $table->string('address2');
            $table->string('address3');
            $table->string('pincode');
            $table->bigInteger('cityId');
            $table->string('secuityQuestion');
            $table->string('secuityQuestionAnswer');
            $table->bigInteger('RefTimeZoneId');
            $table->bigInteger('userTypeId');
            $table->string('otherInfo');
            $table->bigInteger('designationId');
            $table->bigInteger('departmentId');
            $table->bigInteger('languageId');
            $table->string('authorityId');
            $table->bigInteger('userIdRA');
            $table->tinyInteger('isUserLoked');
            $table->datetime('loginExpiryDate');
            $table->tinyInteger('isActive');
            $table->bigInteger('domainId');
            $table->string('createdBy');
            $table->string('updatedBy');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('users');
    }

}
