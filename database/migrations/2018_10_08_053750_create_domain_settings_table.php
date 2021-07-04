<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDomainSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('domain_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('domain_name')->nullable();
            $table->string('domain_url')->nullable();
            $table->bigInteger('language_id')->default(0);
            $table->string('encryption_key')->nullable();
            $table->string('created_by')->default(0);
            $table->string('updated_by')->default(0);
            $table->tinyInteger('isActive');
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
        Schema::dropIfExists('domain_settings');
    }
}
