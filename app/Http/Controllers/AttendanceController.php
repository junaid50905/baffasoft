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
        return view('user.attendance.upload-csv');
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
                } else {
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
        return redirect()->route('attendance.report.summary');
    }
    // attendanceIndex
    public function attendanceReportSummarySetDate()
    {
        return view('user.attendance.set-date');
    }

    /**
     * attendanceReportSummaryStore
     */
    public function attendanceReportSummaryStore(Request $request)
    {

        $from = Carbon::createFromFormat('Y-m-d', $request->from_date)->format('d-M-y');
        $to = Carbon::createFromFormat('Y-m-d', $request->to_date)->format('d-M-y');



            $distinctUsers = Attendance::select('user_id')
            ->whereBetween('date', [$from, $to])
            ->groupBy('user_id')
            ->get();

            $distinctUserIds = $distinctUsers->pluck('user_id');

            $allUsers = Attendance::whereIn('user_id', $distinctUserIds)->get();

            $totalPresent = Attendance::whereBetween('date', [$from, $to])->where('clock_in', '!=', '')->get()->count();
            $totalAbsent = Attendance::whereBetween('date', [$from, $to])->where('clock_in', '')->where('clock_out', '')->where('week', '!=', 'Fri')->count();
            $totalLate = Attendance::whereBetween('date', [$from, $to])->where('late', '!=', '')->count();
            $totalEarly = Attendance::whereBetween('date', [$from, $to])->where('early', '>', '0:00')->count();


            return view('user.attendance.view-date-wise-report', compact('distinctUserIds', 'from', 'to', 'totalPresent', 'totalAbsent', 'totalLate', 'totalEarly'));
        




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
