<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettlementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settlements', function (Blueprint $table) {
            $table->id('key');
            $table->string('name');
            $table->string('zone_type');
            
            $table->unsignedBigInteger('locality_id');
            $table->foreign('locality_id')->references('id')->on('localities');
            
            $table->unsignedBigInteger('settlement_type_id');
            $table->foreign('settlement_type_id')->references('id')->on('settlement_types');

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
        Schema::dropIfExists('settlements');
    }
}
