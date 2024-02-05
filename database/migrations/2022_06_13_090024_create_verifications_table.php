<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVerificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id');
            $table->foreignId('money_collection_id');
            $table->date('verification_date')->default(date("Y-m-d"));
            $table->string('form_year',10)->nullable();
            $table->date('approved_date')->default(date("Y-m-d"));
            $table->smallInteger('verification_required')->default(0);
            $table->smallInteger('verification_accept')->default(0);
            $table->text('manager_note')->nullable();
            $table->text('member_message')->nullable();
            $table->boolean('is_approved')->default(0);
            $table->boolean('is_payment')->default(0);
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
        Schema::dropIfExists('verifications');
    }
}
