<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveApprovesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_approves', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('leave_application_id');
            $table->unsignedBigInteger('user_id');
            $table->string('date');
            $table->string('leave_type');
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
        Schema::dropIfExists('leave_approves');
    }
}
