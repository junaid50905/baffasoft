<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveApprove extends Model
{
    use HasFactory;
    protected $table = 'leave_approves';

    protected $fillable = ['leave_application_id ', 'user_id', 'date', 'leave_type'];
}
