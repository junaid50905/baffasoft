<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoneyCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('money_collections', function (Blueprint $table) {
            $table->id();
            $table->integer('member_id')->unsigned();
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->char('voucher_no',12)->nullable();
            $table->string('receipt_type')->nullable();
            $table->char('receipt_year',4)->nullable();
            $table->char('receipt_month',12)->nullable();
            $table->text('receipt_description')->nullable();
            $table->float('amount',10,2);
            $table->date('transaction_date')->useCurrent();
            $table->string('status')->default('Active');
            $table->string('payment_type')->default('Cash');
            $table->string('payment_chq_no')->nullable();
            $table->date('payment_chq_date')->nullable();
            $table->string('payment_bank')->nullable();
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
        Schema::dropIfExists('money_collections');
    }
}
