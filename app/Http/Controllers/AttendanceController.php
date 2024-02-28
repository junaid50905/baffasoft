<?php

namespace Vanguard\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;
use Vanguard\Attendance;
use Carbon\Carbon;

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
        $date = Carbon::createFromFormat('Y-m', $request->year_month);
        $formattedDate = $date->format('M-y');

        $lateCount = Attendance::where('date', 'like', '%'.$formattedDate)->where('user_id', $userId)->where('late', '>', '0:00')->count();
        $absentCount = Attendance::where('date', 'like', '%' . $formattedDate)->where('user_id', $userId)->where('absent', 'TRUE')->where('week', '!=', 'Fri')->count();

        
        return redirect()->back()->with([
            'lateCount'=> $lateCount,
            'month' => $formattedDate,
            'absentCount'=> $absentCount
        ]);
    }
}
