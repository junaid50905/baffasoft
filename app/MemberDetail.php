<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vanguard\Support\Enum\MemberStatus;

class MemberDetail extends Model
{
    use HasFactory;

    protected $dates = ['form_submit_date','particulars_of_certificate_date','date_of_establishment','trade_license_date','board_of_directors_meeting_date','sub_committee_meeting_date','created_at','updated_at'];

    protected $fillable = [
        'money_collection_id', 'is_payment','last_renew_year',
        'form_submit_date',
        'place_of_enlistment', 'firm_type','type_local', 'particulars_of_certificate_number', 'particulars_of_certificate_date',
        'date_of_establishment', 'trade_license_number', 'trade_license_date', 'tin_number', 'vat_registration_number',
        'ff_license_no','name_of_banker','address_of_banker','membership_of_other_trade_organization', 'name_of_authorized_person',
        'no_of_appointed_staff', 'warehouse_office_address', 'warehouse_office_floor_area','other_org',
        'mrn_no'];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
    public function savePaymentHistory($money_collections_id){
        $this->update([
            'is_payment' => 1,
            'money_collection_id' => $money_collections_id
        ]);
        $this->member->updateStatus(MemberStatus::PAID);
    }

    public function updateLastRenewYear($year){
//        if($this->status !== MemberStatus::ACTIVE)
        $this->update([
            'last_renew_year' => $year
        ]);
    }
}
