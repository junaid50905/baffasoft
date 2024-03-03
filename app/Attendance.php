<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $table = "attendance";

    protected $fillable = ['user_id', 'date', 'clock_in', 'clock_out', 'late', 'early', 'absent', 'clockin_clockout', 'week'];
}
