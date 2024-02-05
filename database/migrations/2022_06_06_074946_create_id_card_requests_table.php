<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateIdCardRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::create('id_card_requests', function (Blueprint $table) {
//            $table->id();
//            $table->foreignId('member_id');
//            $table->date('verification_date')->default(date("Y-m-d"));
//            $table->smallInteger('verification_number')->default(0);
//            $table->text('manager_note')->nullable();
//            $table->text('member_message')->nullable();
//            $table->boolean('is_approved')->default(0);
//            $table->timestamps();
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('id_card_requests');
    }
}
