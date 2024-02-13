<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSalary extends Model
{
    use HasFactory;

    protected $table = 'salaries';

    protected $fillable = [
        'user_id', 'basic_salary', 'house_rent_allowance', 'medical_allowance', 'conveyance', 'other_addition', 'provident_fund',
        'tds', 'working_status', 'other_subtraction', 'gross_salary'
    ];



    
}
