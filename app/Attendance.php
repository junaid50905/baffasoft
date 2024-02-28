<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    
    protected $table = "attendance";

    protected $fillable = ['user_id', 'date', 'in_time', 'out_time', 'status'];
}
