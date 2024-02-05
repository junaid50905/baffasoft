<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdCard extends Model
{
    use HasFactory;
    protected $dates = ['created_at', 'updated_at','dob','training_date','delivery_date','police_verification'];

    protected $fillable = [
        'member_id',

        'id_card_number',
        'proximity_number',
        'delivery_date',

        'form_year',
        'card_type',

        'card_holder_photograph_attachment',
        'card_holder_name',
        'card_holder_designation',

        'memship_no',
        'office_address',
        'office_telephone',
        'dob',

        'attachment_name',
        'attachment_number',
        'attachment_file',

        'blood_group',
        'previous_year_id_card_number',
        'police_verification',
        'police_verification_attachment',

        'training_status',
        'training_date',
        'caab_id_no',

        'signatory_attachment',
        'card_holder_signature_attachment',
        'company_owner_id',
        'designation',

        'status',
        'member_comment',
        'id_card_request_id',
        'is_active',

        'created_at',
        'updated_at'
    ];

    public function scopeWhereLike($query, $column, $value)
    {
        return $query->where($column, 'like', '%'.$value.'%');
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function members()
    {
        return $this->belongsToMany(Member::class);
    }

//    public function verifications()
//    {
//        return $this->belongsToMany(Verification::class)->withTimestamps();
//    }

    public function id_card_requests()
    {
        return $this->hasMany(IdCardRequest::class);
    }

    public function id_card_cancel()
    {
        return $this->hasOne(IdCardCancel::class);
    }

    public function id_card_reissue()
    {
        return $this->hasOne(IdCardReissue::class);
    }

    public function company_owner()
    {
        return $this->belongsTo(CompanyOwner::class);
    }

}
