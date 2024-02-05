<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyOwnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_owners', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('designation')->nullable();
            $table->string('nid_no')->nullable();
            $table->string('attach_nid')->nullable();
            $table->string('educational_qualification')->nullable();
            $table->string('attach_educational_qualification')->nullable();
            $table->string('attach_photograph')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('email')->nullable();
//            $table->integer('nationality_id')->unsigned();
            $table->foreignId('nationality_id')->nullable();
            $table->string('attach_signature')->nullable();
            $table->string('experience_year')->nullable();
            $table->string('attach_experience_certificate')->nullable();
            $table->boolean('nominate_for_vote')->default(0);
            $table->boolean('signatory')->default(0);
            $table->boolean('authorized_person')->default(0);
            $table->boolean('is_active')->default(1);
            $table->boolean('is_deleted')->default(0);
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
        Schema::dropIfExists('company_owners');
    }
}
