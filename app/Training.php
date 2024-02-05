<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;

    protected $dates = ['created_at', 'updated_at','participant_dob','certificate_validity', 'delivery_date','applicantion_date','applicant_police_verification_date'];
    protected $fillable = [
        'member_id',
        'participant_id',
        'director_id',
        'created_user_id',
        'created_user_name',
        'updated_user_id',

        'title',
        'category_name',
        'organization_address',
        'training_name',
        'other_training_name',

        'participant_name',
        'participant_designation',
        'participant_tel',
        'participant_mobile',
        'participant_email',
        'participant_dob',
        'participant_qualification',
        'participant_experience',
        'id_card_id',
        'applicant_signature',
//        'previous_caab_id_no',


//        'applicant_national_id_card_number',
//        'applicant_national_id_card_attachment',
//        'applicant_police_verification_date',
//        'applicant_police_verification_attachment',
//        'applicant_photograph_attachment',
        'submission_year',
        'applicantion_date',

        'certificate_number',
        'certificate_validity',
        'delivery_date',
        'caab_id_no',
        'file_number',
        'status',
        'is_payment',
        'money_collection_id'

    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function money_collection()
    {
        return $this->belongsTo(MoneyCollection::class, 'money_collection_id');
    }

    public function created_user()
    {
        return $this->belongsTo(User::class, 'created_user_id');
    }

    public function updated_user()
    {
        return $this->belongsTo(User::class, 'updated_user_id');
    }

    public function participant()
    {
        return $this->belongsTo(CompanyOwner::class, 'participant_id');
    }

    public function director()
    {
        return $this->belongsTo(CompanyOwner::class, 'director_id');
    }

    public function id_card()
    {
        return $this->belongsTo(IdCard::class, 'id_card_id');
    }

    public function changeStatus($activation_key,$status = 1){
        $this->update([
            $activation_key => $status
        ]);
    }
    public function savePaymentHistory($money_collections_id){
        $this->update([
            'is_payment' => 1,
            'money_collection_id' => $money_collections_id,
            'status' => 'Paid'
        ]);
    }
}
