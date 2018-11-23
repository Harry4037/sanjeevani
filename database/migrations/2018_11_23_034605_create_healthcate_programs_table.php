<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHealthcateProgramsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('healthcate_programs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('resort_id')->default(0);
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->dateTime('start_from')->nullable();
            $table->dateTime('end_to')->nullable();
            $table->tinyInteger('is_active')->default(1);
            $table->bigInteger('domain_id')->default(0);
            $table->string('created_by')->default(0);
            $table->string('updated_by')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('healthcate_programs');
    }

}
