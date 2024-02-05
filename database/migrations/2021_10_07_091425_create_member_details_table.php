<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('member_id')->unsigned();
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
//            $table->foreignId('member_id')->constrained('members');
            $table->foreignId('money_collection_id')->nullable();
            $table->boolean('is_payment')->default(0);
            $table->smallInteger('last_renew_year')->default(2023);

            $table->date('form_submit_date')->nullable();
//            $table->string('firm_name')->nullable();
            $table->string('place_of_enlistment')->nullable();

            $table->string('firm_type')->nullable();
            $table->string('attach_article')->nullable();

            $table->string('type_local')->nullable();
            $table->string('particulars_of_certificate_number')->nullable();
            $table->date('particulars_of_certificate_date')->nullable();
            $table->string('attach_incorporation_certificate')->nullable();

            $table->date('date_of_establishment')->nullable();
            $table->string('trade_license_number')->nullable();
            $table->string('trade_license_date')->nullable();
            $table->string('attach_trade_license')->nullable();
            $table->string('tin_number')->nullable();
            $table->string('attach_e_tin_certificate')->nullable();
            $table->string('vat_registration_number')->nullable();
            $table->string('attach_vat_registration_certificate')->nullable();

            $table->string('ff_license_no')->nullable();        // new
            $table->string('attach_ff_license_no')->nullable(); //new


            $table->text('name_of_banker')->nullable();    // new
            $table->text('address_of_banker')->nullable(); // new
            $table->string('attach_bank_solvency_certificate')->nullable();

            $table->string('membership_of_other_trade_organization')->nullable();
            $table->string('attach_membership_of_other_trade_organization')->nullable(); // new
            $table->string('name_of_authorized_person')->nullable();

            $table->string('no_of_appointed_staff')->nullable();
            $table->string('attach_no_of_appointed_staff')->nullable();

            $table->string('warehouse_office_address')->nullable();
            $table->string('warehouse_office_floor_area')->nullable();

//Name of the existing member organization(s) of BAFFA if any:
            $table->string('other_org')->nullable();

// new
            $table->string('attach_proposed_seconded_by')->nullable();
            $table->string('attach_declaration_undertaking')->nullable();

            $table->string('attach_inspection_report')->nullable();
            $table->string('attach_checklist')->nullable();
            $table->date('sub_committee_meeting_date')->nullable();
            $table->string('board_of_directors_meeting_no')->nullable();
            $table->date('board_of_directors_meeting_date')->nullable();

            $table->string('attach_relevent_document_1')->nullable();
            $table->string('attach_relevent_document_2')->nullable();
            $table->string('attach_relevent_document_3')->nullable();

            $table->timestamps();

//            $table->string('office_tenancy_agreement')->nullable();  // new
//            $table->string('attach_prescribed_declaration')->nullable();  // new

//            $table->string('head_office_address')->nullable();
//            $table->string('head_office_floor_area')->nullable();
//            $table->string('head_office_telephone_no')->nullable();
//            $table->string('head_office_fax_no')->nullable();
//            $table->string('head_office_mobile_no')->nullable();
//            $table->string('head_office_email_address')->nullable();
//
//            $table->string('branch_office_address')->nullable();
//            $table->string('branch_office_floor_area')->nullable();
//            $table->string('branch_office_telephone_no')->nullable();
//            $table->string('branch_office_mobile_no')->nullable();
//            $table->string('branch_office_email_address')->nullable();

//            $table->string('proposed_by_company')->nullable();
//            $table->string('proposed_by_name_and_designation')->nullable();
//            $table->string('proposed_by_membership_no')->nullable();
//            $table->string('proposed_by_forwarding_license_no')->nullable();
//            $table->string('attach_proposed_by_signature_of_seconder')->nullable();
//            $table->date('proposed_by_date')->nullable();
//            $table->string('proposed_by_place')->nullable();
//
//
//            $table->string('seconded_by_company')->nullable();
//            $table->string('seconded_by_name_and_designation')->nullable();
//            $table->string('seconded_by_membership_no')->nullable();
//            $table->string('seconded_by_forwarding_license_no')->nullable();
//            $table->string('attach_seconded_by_signature')->nullable();
//            $table->date('seconded_by_date')->nullable();
//            $table->string('seconded_by_place')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_details');
    }
}
