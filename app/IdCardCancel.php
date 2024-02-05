<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdCardCancel extends Model
{
    use HasFactory;

    protected $dates = ['created_at', 'updated_at','submit_date'];

    protected $fillable = [
        'id_card_id',

        'submit_date',
        'status',

        'created_at',
        'updated_at'
    ];

    public function id_card()
    {
        return $this->belongsTo(IdCard::class, 'id_card_id');
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
}
