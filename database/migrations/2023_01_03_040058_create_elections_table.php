<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateElectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('elections', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('election_session')->nullable();
            $table->date('election_date')->nullable();
            $table->date('nomination_from_submission_deadline')->nullable();
            $table->string('status')->default('Pending');
//
            $table->string('chairman_name')->nullable();
            $table->string('attachment_chairman_signature')->nullable();

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
        Schema::dropIfExists('elections');
    }
}
