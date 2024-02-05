<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberAddress extends Model
{
    use HasFactory;

    protected $fillable = ['member_id','member_address_type','address','floor_area','telephone_no','fax_no','mobile_no','email_address','website'];


    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}
