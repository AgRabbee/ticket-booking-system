<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id');
            $table->date('date');
            $table->string('start_time');
            $table->unsignedBigInteger('bus_id');
            $table->unsignedBigInteger('start_point');
            $table->unsignedBigInteger('end_point');
            $table->integer('fare');
            $table->unsignedBigInteger('driver_id');
            $table->timestamps();

            //foreing keys
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('bus_id')->references('id')->on('company_transport')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('start_point')->references('id')->on('districts')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('end_point')->references('id')->on('districts')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('driver_id')->references('id')->on('company_user')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trips');
    }
}
