<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayableSalary extends Model
{
    use HasFactory;

    protected $table = 'payable_salaries';

    protected $fillable = [
        'basic_salary', 'house_rent', 'medical', 'conveyance', 'other_addition', 'provident_fund', 'tds', 'other_subtraction', 'absent', 'late', 'late_deduction', 'absent_deduction' , 'paid_year_month', 'payment_status', 'total_salary', 'total_payable', 'total_deduction', 'total_deduction_after_change', 'net_payment'
    ];
}