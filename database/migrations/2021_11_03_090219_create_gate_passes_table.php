<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGatePassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gate_passes', function (Blueprint $table) {
            $table->id();
            $table->integer('member_id')->unsigned();
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->string('master_airway_bill_no')->nullable();
            $table->string('contents')->nullable();
            $table->string('weight')->nullable();
            $table->string('flight_no')->nullable();
            $table->string('destination')->nullable();
            $table->string('routing')->nullable();
            $table->integer('on_behalf_of_member_id')->unsigned()->nullable();
//            $table->string('name_of_shipper')->nullable();
            $table->string('shipper_invoice_no')->nullable();
            $table->date('date')->nullable();
            $table->string('cargo_bound_for')->nullable();
            $table->string('agent_name')->nullable();
            $table->string('agent_id_no')->nullable();
            $table->string('vehicle_no')->nullable();
            $table->date('vehicle_date_of_entry')->nullable();
            $table->time('vehicle_time_of_entry')->nullable();
            $table->string('accepted_of_cargo')->nullable();
            $table->string('special_cargo')->nullable();
            $table->string('no_of_piece')->nullable();
            $table->string('gross_weight')->nullable();

//            $table->text('dimension')->nullable();
            $table->text('dimensioni')->nullable();
            $table->text('dimensionii')->nullable();
            $table->text('dimensioniii')->nullable();
            $table->text('dimensioniv')->nullable();
            $table->text('dimensionv')->nullable();
            $table->text('dimensionvi')->nullable();
            $table->string('vwt')->nullable();
            $table->string('cbm')->nullable();
            $table->string('chargeable_weight')->nullable();
            $table->dateTime('weight_taken_date_time')->nullable();
            $table->smallInteger('print_times')->default(0);
            $table->boolean('is_active')->default(false);
            $table->integer('created_user_id')->unsigned();
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
        Schema::dropIfExists('gate_passes');
    }
}
