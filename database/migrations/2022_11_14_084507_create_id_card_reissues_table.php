<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIdCardReissuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('id_card_reissues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_card_id');
            $table->foreignId('money_collection_id')->nullable();
            $table->boolean('is_payment')->default(0);
            $table->date('submit_date')->nullable();
            $table->string('reissue_reason')->nullable();
            $table->string('attachment_file')->nullable();
            $table->string('status')->default('Pending');
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
        Schema::dropIfExists('id_card_reissues');
    }
}
