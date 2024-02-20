<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveApplication extends Model
{
    use HasFactory;

    protected $table = 'leave_applications';

    protected $fillable = ['user_id', 'manager_id', 'leave_type', 'leave_from', 'leave_to', 'leave_days', 'purpose', 'status'];
}
