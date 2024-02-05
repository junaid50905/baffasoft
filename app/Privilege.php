<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
    use HasFactory;

    public function members()
    {
        return $this->belongsToMany(Member::class)->withTimestamps();
    }
}
