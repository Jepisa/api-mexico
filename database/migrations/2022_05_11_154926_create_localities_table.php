<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocalitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('localities', function (Blueprint $table) {
            $table->id();
            $table->string('zip_code');
            $table->string('locality');

            $table->unsignedBigInteger('federal_entity_id');
            $table->foreign('federal_entity_id')->references('key')->on('federal_entities');

            $table->unsignedBigInteger('municipality_id');
            $table->foreign('municipality_id')->references('key')->on('municipalities');

            $table->timestamps();
            $table->index('zip_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('localities');
    }
}
