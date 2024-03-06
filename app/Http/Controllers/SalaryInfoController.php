<?php

namespace Vanguard\Http\Controllers;

use Illuminate\Http\Request;
use Vanguard\EmployeeSalary;
use Vanguard\UserProfile;

class SalaryInfoController extends Controller
{
    /**
     * salaryInfo
     */
    public function salaryInfo()
    {
        return view('user.salary.salary-info');
    }

    /**
     * salaryInfoStore
     */
    public function salaryInfoStore(Request $request)
    {
        $office = $request->place_of_posting;
        $year_month = $request->year_month;

        $usersBasedOnPlaceOfPosting = UserProfile::where('place_of_posting', $request->place_of_posting)->get();

        $salaryPaidUsers = [];


        foreach ($usersBasedOnPlaceOfPosting as $user) {
            $salaryPaidUser = EmployeeSalary::where('user_id', $user->user_id)->where('paid_year_month', $request->year_month)->where('payment_status', 'paid')->first();

            if ($salaryPaidUser !== null) {
                $salaryPaidUsers[] = $salaryPaidUser;
            }
        }
        return view('user.salary.index', compact('salaryPaidUsers', 'office', 'year_month'));
    }
}
