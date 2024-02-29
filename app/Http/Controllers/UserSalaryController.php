<?php

namespace Vanguard\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Vanguard\Attendance;
use Vanguard\EmployeeSalary;
use Vanguard\PayableSalary;
use Vanguard\UserSalary;

class UserSalaryController extends Controller
{

    // salary update
    /**
     * From profile update, throughout this function, salary will be set for a user(employee)
     */
    public function updateSalary(Request $request, $user)
    {
        $request->validate([
            'basic_salary' => 'required|integer',
        ]);


        $basic_salary = $request->basic_salary;
        $house_rent_allowance = $request->house_rent_in_percent / 100;
        $medical_allowance = $request->medical_allowance_in_percent / 100;
        $conveyance = $request->conveyance_in_percent / 100;
        $other_addition = $request->other_addition;

        $tds = $request->tds;
        $provident_fund = $request->provident_fund_in_percent / 100;
        $other_subtraction = $request->other_subtraction;



        $house_rent = floor($basic_salary * $house_rent_allowance);
        $medical = floor($basic_salary * $medical_allowance);
        $conv = floor($basic_salary * $conveyance);

        $provident = floor($basic_salary * $provident_fund);

        $gross_salary = ($basic_salary + $house_rent + $medical + $conv + $other_addition) - ($tds + $provident + $other_subtraction);


        $data = [
            'user_id' => $user->id,
            'basic_salary' => $basic_salary,
            'house_rent_in_percent' => $request->house_rent_in_percent,
            'medical_allowance_in_percent' => $request->medical_allowance_in_percent,
            'conveyance_in_percent' => $request->conveyance_in_percent,
            'provident_fund_in_percent' => $request->provident_fund_in_percent,
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

    //showPayableSalary
    public function showPayableSalary($user)
    {
        $userProfile = $user->userProfile;
        $rateOfPay = $user->salary;
        return view('user.pay-salary', compact('user', 'userProfile', 'rateOfPay'));
    }

    // createPayableSalary
    /**
     * This function will work after click the calculate net payment button.
     */
    public function createPayableSalary(Request $request, $user)
    {
        // $request->validate([
        //     'basic_salary' => 'required',
        //     'house_rent' => 'required',
        //     'medical' => 'required',
        //     'conveyance' => 'required',
        //     'other_addition' => 'required',
        //     'provident_fund' => 'required',
        //     'tds' => 'required',
        //     'other_subtraction' => 'required',
        //     'paid_year_month' => 'required',
        //     'payment_status' => 'required',
        // ]);
        $basic_salary = $request->basic_salary;
        $house_rent = $request->house_rent;
        $medical = $request->medical;
        $conveyance = $request->conveyance;
        $other_addition = $request->other_addition;
        $provident_fund = $request->provident_fund;
        $tds = $request->tds;
        $other_subtraction = $request->other_subtraction;
        $absent = $request->absent;
        $late = $request->late;
        $paid_year_month = $request->paid_year_month;
        $payment_status = $request->payment_status;

        $totalPayable = $basic_salary + $house_rent + $medical + $conveyance + $other_addition;
        $totalDeductionAfterChange = $tds + $provident_fund + $other_subtraction;


        $netPayment = $totalPayable - $totalDeductionAfterChange;

        $data = [
            'user_id' => $user->id,
            'basic_salary' => $basic_salary,
            'house_rent' => $house_rent,
            'medical' => $medical,
            'conveyance' => $conveyance,
            'other_addition' => $other_addition,
            'provident_fund' => $provident_fund,
            'tds' => $tds,
            'other_subtraction' => $other_subtraction,
            'absent' => $absent,
            'late' => $late,
            'paid_year_month' => $paid_year_month,
            'payment_status' => $payment_status,
            'total_payable' => $totalPayable,
            'total_deduction_after_change' => $totalDeductionAfterChange,
            'net_payment' => $netPayment,
        ];


        if ($payment_status === 'calculate') {
            if (PayableSalary::where('user_id', $user->id)->exists()) {
                PayableSalary::where('user_id', $user->id)->update($data);
            } else {
                PayableSalary::insert($data);
            }
        }

        // PayableSalary::insert($data);

        //PayableSalary::insert($data);
        // $allPayents = PayableSalary::where('user_id', $user->id)->get();
        // foreach ($allPayents as $payment) {
        //     if($paid_year_month == $payment->paid_year_month){
        //         return redirect()->back()->with('already_paid', 'Payment already paid for this month');
        //     }else{
        //         PayableSalary::insert($data);
        //     }
        // }

        $salary = $user->salary;
        $afterChangeSalary = $user->payableSalary;
        return view('user.paid-salary', compact('afterChangeSalary', 'user', 'salary'));
    }

    // paySalary
    public function insertSalary($user)
    {
        return view('user.paid-salary', compact('user'));
    }

    // paidSalaryStore
    public function paidSalaryStore(Request $request, $user)
    {
        // $request->validate([
        //     'basic_salary' => 'required',
        //     'house_rent' => 'required',
        //     'medical' => 'required',
        //     'conveyance' => 'required',
        //     'other_addition' => 'required',
        //     'provident_fund' => 'required',
        //     'tds' => 'required',
        //     'other_subtraction' => 'required',
        //     'absent_deduction' => 'required',
        //     'late_deduction' => 'required',
        //     'payment_status' => 'required',
        //     'total_payable' => 'required',
        //     'total_deduction_after_change' => 'required',
        //     'net_payment' => 'required',
        //     'paid_year_month' => 'required',
        // ]);
        $date = Carbon::createFromFormat('Y-m', $request->paid_year_month);
        $formattedDate = $date->format('M-y');

        $lateCount = Attendance::where('date', 'like', '%' . $formattedDate)->where('user_id', $user->id)->where('late', '>', '0:00')->count();
        $absent = Attendance::where('date', 'like', '%' . $formattedDate)->where('user_id', $user->id)->where('absent', 'TRUE')->where('week', '!=', 'Fri')->count();

        $late = intval($lateCount / 3);
        $deductionForPerAbsent = $request->basic_salary / 30;

        $totalLateAbsentDeduction = ($late + $absent) * $deductionForPerAbsent;

        $data = [
            'user_id' => $request->user_id,
            'basic_salary' => $request->basic_salary,
            'house_rent' =>  $request->house_rent,
            'medical' =>  $request->medical,
            'conveyance' =>  $request->conveyance,
            'other_addition' =>  $request->other_addition,
            'provident_fund' =>  $request->provident_fund,
            'tds' =>  $request->tds,
            'other_subtraction' =>  $request->other_subtraction,
            'absent' =>  $absent,
            'late' =>  $late,
            'late_absent_deduction' => $totalLateAbsentDeduction,
            'payment_status' =>  $request->payment_status,
            'total_payable' => $request->total_payable,
            'total_deduction_after_change' => $request->total_deduction_after_change,
            'net_payment' =>  $request->net_payment,
            'paid_year_month' => $request->paid_year_month,
        ];
        EmployeeSalary::insert($data);

        return redirect()->to('admin/users');
    }

    // userSalaryHistory
    /**
     * This funciton will show you individual salary history
     */
    public function userSalaryHistory($user)
    {
        $salaries = EmployeeSalary::where('user_id', $user->id)->orderBy('id', 'desc')->get();
        return view('user.user-salary-index', compact('salaries', 'user'));
    }

    // userUpdateSalary
    /**
     *
     */
    public function userUpdateSalary($user, $salaryId)
    {
        $salary = EmployeeSalary::where('id', $salaryId)->first();
        $rateOfPay = UserSalary::where('user_id', $user->id)->first();
        return view('user.update-monthly-salary', compact('user', 'salary', 'rateOfPay'));
    }

    //userUpdateSalaryStore
    /**
     * 
     */
    public function userUpdateSalaryStore(Request $request, $user, $salaryId)
    {
        $basic_salary = $request->basic_salary;
        $house_rent = $request->house_rent;
        $medical = $request->medical;
        $conveyance = $request->conveyance;
        $other_addition = $request->other_addition;
        $provident_fund = $request->provident_fund;
        $tds = $request->tds;
        $other_subtraction = $request->other_subtraction;
        $absent = $request->absent;
        $late = $request->late;
        $paid_year_month = $request->paid_year_month;
        $payment_status = $request->payment_status;

        $totalPayable = $basic_salary + $house_rent + $medical + $conveyance + $other_addition;
        $totalDeductionAfterChange = $tds + $provident_fund + $other_subtraction;


        $netPayment = $totalPayable - $totalDeductionAfterChange;

        $data = [
            'user_id' => $user->id,
            'basic_salary' => $basic_salary,
            'house_rent' => $house_rent,
            'medical' => $medical,
            'conveyance' => $conveyance,
            'other_addition' => $other_addition,
            'provident_fund' => $provident_fund,
            'tds' => $tds,
            'other_subtraction' => $other_subtraction,
            'absent' => $absent,
            'late' => $late,
            'paid_year_month' => $paid_year_month,
            'payment_status' => $payment_status,
            'total_payable' => $totalPayable,
            'total_deduction_after_change' => $totalDeductionAfterChange,
            'net_payment' => $netPayment,
        ];
        EmployeeSalary::where('id', $salaryId)->update($data);

        return redirect()->back()->with('salary_updated', "Salary has been updated");
        
    }
}
