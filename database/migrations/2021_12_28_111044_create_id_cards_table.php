<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIdCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('id_cards', function (Blueprint $table) {
            $table->id();

            $table->integer('member_id')->unsigned();
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');

            $table->string('id_card_number')->nullable();
            $table->string('proximity_number')->nullable();

            $table->string('form_year',10)->nullable();
            $table->string('card_type',10)->nullable();

            $table->string('signatory_attachment')->nullable();
            $table->string('card_holder_photograph_attachment')->nullable();
            $table->string('card_holder_name')->nullable();
            $table->string('card_holder_designation')->nullable();

            $table->string('memship_no')->nullable();
            $table->longText('office_address')->nullable();
            $table->string('office_telephone')->nullable();
            $table->date('dob')->nullable();

            $table->string('attachment_name')->nullable();
            $table->string('attachment_number')->nullable();
            $table->string('attachment_file')->nullable();

            $table->string('blood_group')->nullable();
            $table->string('previous_year_id_card_number')->nullable();
            $table->string('police_verification')->nullable();
            $table->string('police_verification_attachment')->nullable();

            $table->string('training_status')->nullable();
            $table->date('delivery_date')->nullable();
            $table->date('training_date')->nullable();
            $table->string('caab_id_no')->nullable();

            $table->string('card_holder_signature_attachment')->nullable();
            $table->bigInteger('company_owner_id')->unsigned()->index();
//            $table->foreign('company_owner_id')->references('id')->on('company_owners')->onDelete('cascade');
            $table->string('designation')->nullable();

            $table->string('status')->default('0');
            $table->text('member_comment')->nullable();
//            $table->foreignId('id_card_request_id')->nullable();
            $table->boolean('is_active')->default(1);

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
        Schema::dropIfExists('id_cards');
    }
}
