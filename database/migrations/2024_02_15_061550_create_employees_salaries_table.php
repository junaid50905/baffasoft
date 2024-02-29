<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees_salaries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->integer('basic_salary')->nullable();
            $table->integer('house_rent')->nullable();
            $table->integer('medical')->nullable();
            $table->integer('conveyance')->nullable();
            $table->integer('other_addition')->nullable();
            $table->integer('provident_fund')->nullable();
            $table->integer('tds')->nullable();
            $table->integer('other_subtraction')->nullable();
            $table->integer('absent')->nullable();
            $table->integer('late')->nullable();
            $table->integer('late_absent_deduction')->nullable();
            $table->integer('total_payable')->nullable();
            $table->integer('total_deduction_after_change')->nullable();
            $table->integer('net_payment')->nullable();
            $table->string('paid_year_month')->nullable();
            $table->string('payment_status')->nullable();
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
        Schema::dropIfExists('employees_salaries');
    }
}
