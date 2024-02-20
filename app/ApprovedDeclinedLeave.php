<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovedDeclinedLeave extends Model
{
    use HasFactory;
    protected $table = 'approved_decline_leaves';

    protected $fillable = [
        'leave_application_id', 'user_id', 'casual_leave', 'sick_leave', 'annual_leave', 'maternity_leave', 'paternity_leave', 'special_leave', 'annual_leave_total', 'status'
    ];
}
