<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdCardReissue extends Model
{
    use HasFactory;
    protected $dates = ['created_at', 'updated_at','submit_date'];

    protected $fillable = [
        'id_card_id',
        'money_collection_id',
        'is_payment',
        'reissue_reason',
        'submit_date',
        'attachment_file',
        'status',
        'created_at',
        'updated_at'
    ];

    public function id_card()
    {
        return $this->belongsTo(IdCard::class);
    }
    public function member()
    {
        return $this->hasOneThrough(Member::class,IdCard::class,'id','id','id_card_id','member_id');
    }

    public function members()
    {
        return $this->hasManyThrough(Member::class,IdCard::class,'id','id','id_card_id','member_id');
//        return $this->belongsToMany(Member::class);
    }

    public function savePaymentHistory($money_collections_id){
        $this->update([
            'is_payment' => 1,
            'money_collection_id' => $money_collections_id,
            'status' => 'Paid'
        ]);
    }
}
