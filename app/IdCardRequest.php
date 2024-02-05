<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdCardRequest extends Model
{
    use HasFactory;

    protected $dates = ['created_at', 'updated_at','verification_date'];

    protected $fillable = [
        'member_id',
        'verification_date',
        'verification_number',
        'manager_note',
        'member_message',
        'is_approved',
        'created_at',
        'updated_at'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
