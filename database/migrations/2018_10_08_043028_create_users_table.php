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
            $table->bigInteger('salutation_id')->default(0);
            $table->string('user_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('mid_name')->nullable();
            $table->string('last_name')->nullable();
            $table->enum('gender', ['M', 'F'])->nullable();
            $table->bigInteger('user_type_id')->default(0);
            $table->bigInteger('designation_id')->default(0);
            $table->bigInteger('department_id')->default(0);
            $table->bigInteger('city_id')->default(0);
            $table->bigInteger('language_id')->default(0);
            $table->string('email_id')->nullable();
            $table->string('alternate_email_id')->nullable();
            $table->string('screen_name')->nullable();
            $table->dateTime('date_of_joining')->nullable();
            $table->string('authority_id')->default(0);
            $table->bigInteger('user_id_RA')->nullable();
            $table->dateTime('date_of_birth')->nullable();
            $table->string('profile_pic_path')->nullable();
            $table->string('id_card')->nullable();
            $table->tinyInteger('is_user_loked')->default(0);
            $table->string('mobile_number')->nullable();
            $table->string('other_contact_number')->nullable();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('address3')->nullable();
            $table->string('pincode')->nullable();
            $table->string('secuity_question')->nullable();
            $table->string('secuity_questio_answer')->nullable();
            $table->bigInteger('ref_time_zone_id')->nullable();
            $table->datetime('login_expiry_date')->nullable();
            $table->string('other_info')->nullable();
            $table->string('password')->nullable();
            $table->string('remember_token')->nullable();
            $table->string('aadhar_id')->nullable();
            $table->string('voter_id')->nullable();
            $table->tinyInteger('is_active')->default(1);
            $table->bigInteger('domain_id')->default(0);
            $table->string('otp')->nullable();
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
        Schema::dropIfExists('users');
    }

}
