<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveAllocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_allocations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');

            $table->integer('casual_leave_allowed')->default(10);
            $table->integer('sick_leave_allowed')->default(14);
            $table->integer('annual_leave_allowed')->default(18);
            $table->integer('maternity_leave_allowed')->default(0);
            $table->integer('paternity_leave_allowed')->default(14);
            $table->integer('annual_leave_total')->default(0);

            $table->integer('casual_leave_enjoyed')->default(0);
            $table->integer('sick_leave_enjoyed')->default(0);
            $table->integer('annual_leave_enjoyed')->default(0);
            $table->integer('maternity_leave_enjoyed')->default(0);
            $table->integer('paternity_leave_enjoyed')->default(0);
            $table->integer('annual_leave_total_enjoyed')->default(0);
            $table->integer('special_leave_enjoyed')->default(0);

            $table->integer('casual_leave_balance')->default(10);
            $table->integer('sick_leave_balance')->default(14);
            $table->integer('annual_leave_balance')->default(18);
            $table->integer('maternity_leave_balance')->default(0);
            $table->integer('paternity_leave_balance')->default(14);
            $table->integer('annual_leave_total_balance')->default(0);

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
        Schema::dropIfExists('leave_allocations');
    }
}
