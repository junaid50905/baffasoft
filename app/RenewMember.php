<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vanguard\Support\Enum\MemberStatus;

class RenewMember extends Model
{
    use HasFactory;

    protected $dates = ['date_of_renewal','date_of_admission','freight_forwarders_license_date','trade_license_date'];


    protected $fillable = [
        'member_id','status','money_collection_id','is_payment',
        'date_of_renewal','submission_year',
        'firm_name','firm_type','type_local','contact_person_id','contact_person_name','contact_person_photo','contact_person_designation','contact_person_designation_other','membership_number','date_of_admission','place_of_enlistment',
        'registered_office','current_office','branch_office',
        'telephone_no','fax_no','mobile_no','email_address','website',
        'freight_forwarders_license_number','freight_forwarders_license_date',
        'trade_license_number','trade_license_date',
        'tin_number','any_change','structure_change','structure_change_charge',
        'attach_ff_license_no','attach_trade_license','attach_e_tin_certificate'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function company_owners()
    {
        return $this->belongsToMany(CompanyOwner::class)->withTimestamps();
    }

    public function contact_person()
    {
        return $this->belongsToMany(CompanyOwner::class)->where('authorized_person',1)->orderBy('id', 'desc')->limit(1);
    }

    public function member_detail()
    {
        return $this->hasOneThrough(MemberDetail::class,Member::class,'id','member_id','member_id','id');
//        return $this->belongsTo(Member::class, 'member_id');
    }

    public function checkPayment(){
        $result = 0;
        $year_difference_label = '';
        $month_difference_label = '';
        $structure_label = '';
        $re_admission_label = '';
        $submission_year = $this->submission_year;
        $last_renew_year = $this->member_detail->last_renew_year;
        $date_of_renewal = $this->date_of_renewal;
        $applicable_year = (int)date('Y');//(int)date('Y', strtotime($date_of_renewal));
        $applicable_month = (int)date('m');//(int)date('m', strtotime($date_of_renewal));
        $difference = (int)($submission_year - $last_renew_year); // 2024 - 2023
        if($difference >= 1) {
            if ($difference == 1) {
                $year_difference_label = 'Yearly Fee( ' . $applicable_year . ' )- ' . '5000TK';
                if ($applicable_year == $submission_year && $applicable_month - 3 > 1) {
                    $result = 5000 + ($applicable_month * 200);
                    $month_difference_label = ',Late Fee(Jan - ' . date('M') . ')- ' . ($applicable_month * 200) . 'TK';

                }
                else
                    $result = 5000;
            } else{
                $year_difference_label = 'Yearly Fee(' . ($last_renew_year + 1) . '-' . $applicable_year . ')- ' . ($difference * 5000) . 'TK';
                $result = $difference * 5000 + 6000;
                $re_admission_label = ',Re-Admission Fee- 6000TK';

            }
        }
        if($result > 0 && $this->any_change){
            $result += (int)$this->structure_change_charge;
            $structure_label = ',Structure Change Charge- ' . $this->structure_change_charge . 'TK';
        }
        $description = 'Membership Annual Subscription' . '[' . $year_difference_label . $re_admission_label . $month_difference_label . $structure_label .']' ;
        return ['description'=>$description,'amount'=>$result];

    }

    public function renew_member_address()
    {
        return $this->hasMany(RenewMemberAddress::class);
    }

    public function registered_office()
    {
        return $this->hasOne(RenewMemberAddress::class)->where('member_address_type','register');
    }
    public function branch_office()
    {
        return $this->hasOne(RenewMemberAddress::class)->where('member_address_type','branch');
    }
    public function current_office()
    {
        return $this->hasOne(RenewMemberAddress::class)->where('member_address_type','current');
    }

    //    Pending -> Verified -> Inspected -> Wait For Approval -> Admin Approval -> Paid -> Active
    //    Pending -> Accepted -> Paid -> Done
    public function updateStatus($status = MemberStatus::PENDING){
        $this->update([
            'status' => $status
        ]);
    }

    public function savePaymentHistory($money_collections_id){
        $this->update([
            'is_payment' => 1,
            'money_collection_id' => $money_collections_id
        ]);
        $this->updateStatus(MemberStatus::PAID);
    }
}
