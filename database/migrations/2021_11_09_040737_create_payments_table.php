<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->morphs('paymentable');
            $table->integer('member_id')->unsigned();
            $table->string('bmn',45)->nullable();
            $table->string('payment_type')->default('Cash');
            $table->char('receipt_no',12)->default('20210220001');
            $table->string('purpose')->default('GatePass');
            $table->float('amount',10,2);
            $table->integer('created_user_id')->unsigned();
            $table->integer('updated_user_id')->unsigned()->nullable();
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
        Schema::dropIfExists('payments');
    }
}
