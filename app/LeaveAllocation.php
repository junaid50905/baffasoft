<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveAllocation extends Model
{
    use HasFactory;

    protected $table = 'leave_allocations';

    protected $fillable = [
        'user_id', 'casual_leave_allowed', 'sick_leave_allowed', 'annual_leave_allowed', 'maternity_leave_allowed', 'paternity_leave_allowed', 'annual_leave_total',
        'casual_leave_enjoyed', 'sick_leave_enjoyed', 'annual_leave_enjoyed', 'maternity_leave_enjoyed', 'paternity_leave_enjoyed', 'annual_leave_total_enjoyed',
        'special_leave_enjoyed', 'casual_leave_balance', 'sick_leave_balance', 'annual_leave_balance', 'maternity_leave_balance', 'paternity_leave_balance', 'annual_leave_total_balance'
    ];
}
