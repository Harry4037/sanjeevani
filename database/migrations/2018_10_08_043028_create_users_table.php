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
            $table->string('password')->nullable();
            $table->string('first_name')->nullable();
            $table->string('mid_name')->nullable();
            $table->string('last_name')->nullable();
            $table->enum('gender', ['M', 'F'])->nullable();
            $table->string('email_id')->nullable();
            $table->string('alternate_email_id')->nullable();
            $table->bigInteger('user_type_id')->default(0);
            $table->bigInteger('designation_id')->default(0);
            $table->bigInteger('department_id')->default(0);
            $table->bigInteger('city_id')->default(0);
            $table->bigInteger('language_id')->default(0);
            $table->string('screen_name')->nullable();
            $table->dateTime('date_of_joining')->useCurrent();
            $table->string('authority_id')->default(0);
            $table->dateTime('date_of_birth')->useCurrent();
            $table->tinyInteger('is_user_loked')->default(0);
            $table->string('profile_pic_path')->nullable();
            $table->integer('mobile_number')->nullable();
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
            $table->bigInteger('user_id_RA')->nullable();
            $table->tinyInteger('is_active')->default(1);
            $table->bigInteger('domain_id')->default(0);
            $table->string('remember_token')->nullable();
            $table->string('createdBy')->default(0);
            $table->string('updatedBy')->default(0);
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
