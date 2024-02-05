<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVotersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('election_id');
            $table->foreignId('member_id');
            $table->foreignId('company_owner_id')->nullable();
            $table->string('voter_name')->nullable();
            $table->string('voter_designation')->nullable();
            $table->string('voter_e_tin_no')->nullable();
            $table->string('voter_e_tin_attachment')->nullable();
            $table->string('voter_nid_no')->nullable();
            $table->string('voter_address')->nullable();
            $table->string('voter_tel')->nullable();
            $table->string('voter_mob')->nullable();
            $table->string('voter_fax')->nullable();
            $table->string('voter_email')->nullable();
            $table->string('voter_signature')->nullable();
            $table->string('voter_image')->nullable();
            $table->string('voter_location')->nullable();
            $table->string('vote_casting_location')->nullable();
            $table->string('vote_cast')->default(0);

            $table->foreignId('manager_id')->nullable();
            $table->string('manager_signature')->nullable();
            $table->string('manager_name')->nullable();
            $table->string('manager_designation')->nullable();
            $table->date('manager_date')->nullable();

            $table->boolean('due_list')->default(0);
            $table->boolean('preliminary_list')->default(0);
            $table->boolean('final_list')->default(0);
            $table->string('voter_number')->nullable();
            $table->boolean('archived')->default(0);
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
        Schema::dropIfExists('voters');
    }
}
