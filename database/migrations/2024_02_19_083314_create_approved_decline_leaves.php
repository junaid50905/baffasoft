<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprovedDeclineLeaves extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approved_decline_leaves', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('leave_application_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('casual_leave')->nullable();
            $table->integer('sick_leave')->nullable();
            $table->integer('annual_leave')->nullable();
            $table->integer('maternity_leave')->nullable();
            $table->integer('paternity_leave')->nullable();
            $table->integer('special_leave')->nullable();
            $table->integer('annual_leave_total')->nullable();
            $table->integer('approved_days')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
            $table->foreign('leave_application_id')->references('id')->on('leave_applications');
            $table->foreign('user_id')->references('user_id')->on('leave_allocations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('approved_decline_leaves');
    }
}
