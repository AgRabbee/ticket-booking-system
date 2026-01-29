<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('payment_id')->nullable();
            $table->string('seat_number');
            $table->integer('seat_status')->comment('0->empty;1->pending;2->complete');
            $table->unsignedBigInteger('trip_id')->nullable();
            $table->timestamps();

            //foreing keys
            $table->foreign('payment_id')->references('id')->on('payment_details')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('trip_id')->references('id')->on('trips')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}
