<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verification extends Model
{
    use HasFactory;

    protected $dates = ['created_at', 'updated_at','verification_date','approved_date'];

    protected $fillable = [
        'member_id',
        'money_collection_id',
        'verification_date',
        'form_year',
        'approved_date',
        'verification_required',
        'verification_accept',
        'manager_note',
        'member_message',
        'is_approved',
        'is_payment',
        'created_at',
        'updated_at'
    ];

    public function members()
    {
        return $this->belongsToMany(Member::class);
    }

    public function id_cards()
    {
        return $this->belongsToMany(IdCard::class)->withTimestamps();
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function savePaymentHistory($money_collections_id){
//        $total_balance = (float)$this->gatepass_balance + (float)$recent_balance;
//        $this->update([
//            'gatepass_balance' => $total_balance
//        ]);
        $this->id_cards()->where('status', 6)->update(['status' => '7']);
        $this->update([
            'is_payment' => 1,
            'money_collection_id' => $money_collections_id,
        ]);
    }
}
