<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('company_name')->unique();
            $table->string('description')->nullable();
            $table->string('address');
            $table->string('reg_no')->unique();
            $table->integer('tin_no')->unique();
            $table->string('company_image');
            $table->string('trade');
            $table->string('vat');
            $table->integer('fees');
            $table->integer('company_status')->comment('0->pending, 1->active, 2->denied');
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
        Schema::dropIfExists('companies');
    }
}
