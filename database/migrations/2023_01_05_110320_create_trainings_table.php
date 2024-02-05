<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->nullable();
//            $table->foreignId('participant_id')->nullable();
            $table->foreignId('director_id')->nullable();
            $table->foreignId('money_collection_id')->nullable();
            $table->boolean('is_payment')->default(0);
            $table->text('organization_address')->nullable();
            $table->string('title')->nullable();

            $table->string('category_name')->nullable();
            $table->enum('training_name', ['dg', 'csa', 'other']);
            $table->string('other_training_name')->nullable();
            $table->string('participant_name')->nullable();
            $table->string('participant_designation')->nullable();
            $table->string('participant_tel')->nullable();
            $table->string('participant_mobile')->nullable();
            $table->string('participant_email')->nullable();
            $table->string('participant_dob')->nullable();
            $table->string('participant_qualification')->nullable();
            $table->text('participant_experience')->nullable();
            $table->string('id_card_id')->nullable();
            $table->string('previous_caab_id_no')->nullable();

            $table->string('applicant_signature')->nullable();
            $table->string('applicant_national_id_card_number')->nullable();
            $table->string('applicant_national_id_card_attachment')->nullable();
            $table->date('applicant_police_verification_date')->nullable();
            $table->string('applicant_police_verification_attachment')->nullable();
            $table->string('applicant_photograph_attachment')->nullable();

            $table->smallInteger('submission_year')->nullable();

            $table->string('applicantion_date')->nullable();

            $table->string('certificate_number')->nullable();
            $table->date('certificate_validity')->nullable();
            $table->date('delivery_date')->nullable();
            $table->string('caab_id_no')->nullable();
            $table->string('file_number')->nullable();
            $table->string('status')->default('Pending');
            $table->integer('created_user_id')->unsigned()->nullable();
            $table->string('created_user_name')->nullable();
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
        Schema::dropIfExists('trainings');
    }
}
