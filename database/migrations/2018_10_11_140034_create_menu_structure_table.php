<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuStructureTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('menu_structure', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->integer('display_order')->default(0);
            $table->bigInteger('parent_id')->default(0);
            $table->string('page_url')->nullable();
            $table->string('image_path')->nullable();
            $table->string('created_by')->default(0);
            $table->string('updated_by')->default(0);
            $table->tinyInteger('is_active')->default(1);
            $table->bigInteger('domain_id')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('menu_structure');
    }

}
