<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdCardRecord extends Model
{
    use HasFactory;
    protected $dates = ['created_at', 'updated_at'];

    protected $fillable = [
        'member_id',
        'bmn_no',
        'year',
        'total',
        'created_at',
        'updated_at'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
