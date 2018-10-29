<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserhealthDetailsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('userhealth_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->default(0);
            $table->tinyInteger('is_diabeties')->default(0);
            $table->tinyInteger('is_ppa')->default(0);
            $table->tinyInteger('hba_1c')->default(0);
            $table->string('fasting')->nullable(0);
            $table->string('bp')->nullable(0);
            $table->string('insullin_dependency')->nullable(0);
            $table->string('medical_documents')->nullable(0);
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
        Schema::dropIfExists('userhealth_details');
    }

}
