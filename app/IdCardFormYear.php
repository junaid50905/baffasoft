<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdCardFormYear extends Model
{
    use HasFactory;
    protected $fillable = ['year','is_active'];

}
