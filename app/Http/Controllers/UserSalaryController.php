<?php

namespace Vanguard\Http\Controllers;

use Illuminate\Http\Request;
use Vanguard\UserSalary;

class UserSalaryController extends Controller
{

    // salary update
    public function updateSalary(Request $request, $user)
    {
        $request->validate([
            'basic_salary' => 'required|integer',
            'other_addition' => 'integer'
        ]);


        $basic_salary = $request->basic_salary;
        $house_rent_allowance = $request->house_rent_allowance / 100;
        $medical_allowance = $request->medical_allowance / 100;
        $conveyance = $request->conveyance / 100;
        $other_addition = $request->other_addition;

        $tds = $request->tds;
        $provident_fund = $request->provident_fund / 100;
        $other_subtraction = $request->other_subtraction;



        $house_rent = floor($basic_salary * $house_rent_allowance);
        $medical = floor($basic_salary * $medical_allowance);
        $conv = floor($basic_salary * $conveyance);

        $provident = floor($basic_salary * $provident_fund);

        $gross_salary = ($basic_salary + $house_rent + $medical + $conv + $other_addition) - ($tds + $provident + $other_subtraction);


        $data = [
            'user_id' => $user->id,
            'basic_salary' => $basic_salary,
            'house_rent_allowance' => $house_rent,
            'medical_allowance' => $medical,
            'conveyance' => $conv,
            'other_addition' => $other_addition,

            'provident_fund' => $provident,
            'tds' => $tds,
            'other_subtraction' => $other_subtraction,
            'gross_salary' => $gross_salary,
        ];

        if (UserSalary::where('user_id', $user->id)->exists()) {
            UserSalary::where('user_id', $user->id)->update($data);
        } else {
            UserSalary::insert($data);
        }

        return redirect()->to('admin/users');

    }
}
