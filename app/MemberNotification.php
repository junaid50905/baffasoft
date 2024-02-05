<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberNotification extends Model
{
    use HasFactory;

    protected $dates = ['created_at', 'updated_at'];

    protected $fillable = [
        'member_id',
        'money_receipt_type_id',
        'message_title',
        'message_description',
        'is_reading',
        'is_active',
        'created_at',
        'updated_at'
        ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function money_receipt_type()
    {
        return $this->belongsTo(MoneyReceiptType::class, 'money_receipt_type_id');
    }
}
