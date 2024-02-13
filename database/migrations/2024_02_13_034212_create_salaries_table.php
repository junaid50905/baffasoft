<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->integer('basic_salary')->nullable();
            $table->integer('house_rent_allowance')->nullable();
            $table->integer('medical_allowance')->nullable();
            $table->integer('conveyance')->nullable();
            $table->integer('other_addition')->nullable();
            $table->integer('provident_fund')->nullable();
            $table->integer('tds')->nullable();
            $table->enum('working_status', ['late', 'absent'])->nullable();
            $table->integer('other_subtraction')->nullable();
            $table->integer('gross_salary')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salaries');
    }
}
