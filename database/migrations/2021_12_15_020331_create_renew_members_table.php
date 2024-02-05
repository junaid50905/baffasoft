<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRenewMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('renew_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id');
            $table->string('status', 20)->index();
            $table->foreignId('money_collection_id')->nullable();
            $table->boolean('is_payment')->default(0);

//            $table->integer('member_id')->unsigned();
//            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');

            $table->smallInteger('submission_year')->nullable();
            $table->date('date_of_renewal')->nullable();
            $table->string('firm_name')->nullable();
            $table->string('firm_type')->nullable();
            $table->string('type_local')->nullable();
            $table->integer('contact_person_id')->unsigned()->nullable();
            $table->string('contact_person_name')->nullable();
            $table->string('contact_person_photo')->nullable();
            $table->string('contact_person_designation')->nullable();
            $table->string('contact_person_designation_other')->nullable();
            $table->string('membership_number')->nullable();
            $table->date('date_of_admission')->nullable();
            $table->string('place_of_enlistment')->nullable();

//            $table->text('registered_office')->nullable();
//            $table->text('current_office')->nullable();
//            $table->text('branch_office')->nullable();

            $table->string('telephone_no')->nullable();
            $table->string('fax_no')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('email_address')->nullable();
            $table->string('website')->nullable();

            $table->string('freight_forwarders_license_number')->nullable();
            $table->string('freight_forwarders_license_date')->nullable();
            $table->string('attach_ff_license_no')->nullable();     //new


            $table->string('trade_license_number')->nullable();
            $table->string('trade_license_date')->nullable();
            $table->string('attach_trade_license')->nullable();     //new

            $table->string('tin_number')->nullable();
            $table->boolean('any_change')->default(0);
            $table->boolean('structure_change')->default(0);
            $table->smallInteger('structure_change_charge')->default(0);
            $table->string('attach_e_tin_certificate')->nullable();   //new

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
        Schema::dropIfExists('renew_members');
    }
}
