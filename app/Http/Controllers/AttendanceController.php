<?php

namespace Vanguard\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;
use Vanguard\Attendance;
use Carbon\Carbon;
use Vanguard\EmployeeSalary;
use Vanguard\User;

class AttendanceController extends Controller
{
    // uploadCSV
    public function uploadCSV()
    {
        return view('attendance.upload-csv');
    }
    // CSVStore
    public function CSVStore(Request $request)
    {
        $csv = Reader::createFromPath($request->file('csv_file')->getRealPath());
        $csv->setHeaderOffset(0);

        foreach ($csv as $record) {
            if (!empty($record['user_id'])) {
                if (Attendance::where('user_id', $record['user_id'])->where('date', $record['date'])->where('absent', "Leave")->exists()) {
                    Attendance::where('user_id', $record['user_id'])->where('date', $record['date'])->where('absent', "Leave")->update([
                        'user_id' => $record['user_id'],
                        'date' => $record['date'],
                        'clock_in' => $record['clock_in'],
                        'clock_out' => $record['clock_out'],
                        'late' => $record['late'],
                        'early' => $record['early'],
                        'absent' => 'Leave',
                        'clockin_clockout' => $record['clockin_clockout'],
                    ]);
                }else{
                    Attendance::insert([
                        'user_id' => $record['user_id'],
                        'date' => $record['date'],
                        'clock_in' => $record['clock_in'],
                        'clock_out' => $record['clock_out'],
                        'late' => $record['late'],
                        'early' => $record['early'],
                        'absent' => $record['absent'],
                        'clockin_clockout' => $record['clockin_clockout'],
                        'week' => $record['week'],
                    ]);
                }                
            } else {
                continue;
            }
        }
        return redirect()->route('attendance.index');
    }
    // attendanceIndex
    public function attendanceIndex()
    {
        return view('attendance.attendance-index');
    }


    // showUserMonthlyAttendance
    public function showUserMonthlyAttendance(Request $request, $userId)
    {
        $request->validate([
            'year_month' => 'required'
        ]);
        if (EmployeeSalary::where('user_id', $userId)->where('paid_year_month', $request->year_month)->first()) {
            return redirect()->back()->with('already_paid', 'Salary has been paid for ' . $request->year_month);
        } else {
            $date = Carbon::createFromFormat('Y-m', $request->year_month);
            $formattedDate = $date->format('M-y');

            $lateCount = Attendance::where('date', 'like', '%' . $formattedDate)->where('user_id', $userId)->where('late', '>', '0:00')->count();
            $absentCount = Attendance::where('date', 'like', '%' . $formattedDate)->where('user_id', $userId)->where('absent', 'TRUE')->where('week', '!=', 'Fri')->count();

            $user = User::where('id', $userId)->first();
            $rateOfPay = $user->salary;
            $afterChangeSalary = $user->payableSalary;


            return view('user.pay-salary', compact('lateCount', 'formattedDate', 'absentCount', 'user', 'rateOfPay', 'afterChangeSalary'));
        }

    }

    // monthlyAttendance
    public function monthlyAttendance($user)
    {
        return view('user.show-attendance-late', compact('user'));
    }
}
