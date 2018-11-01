<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHealthCarePackagesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('health_care_packages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->default(0);
            $table->tinyInteger('is_daibeties')->default(0);
            $table->tinyInteger('is_pp')->default(0);
            $table->tinyInteger('is_habc')->default(0);
            $table->string('fasting')->nullable();
            $table->string('bp')->nullable();
            $table->string('insulin_dependency')->nullable();
            $table->string('medical_documents')->nullable();
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
        Schema::dropIfExists('health_care_packages');
    }

}
