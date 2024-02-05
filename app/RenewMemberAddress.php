<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RenewMemberAddress extends Model
{
    use HasFactory;
    protected $fillable = ['renew_member_id','member_address_type','address','floor_area','telephone_no','fax_no','mobile_no','email_address','website'];

    public function renew_member()
    {
        return $this->belongsTo(RenewMember::class, 'renew_member_id');
    }
}
