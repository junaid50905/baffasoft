<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoneyReceiptType extends Model
{
    use HasFactory;

    public function member_notifications()
    {
        return $this->belongsToMany(MemberNotification::class);
    }

}
