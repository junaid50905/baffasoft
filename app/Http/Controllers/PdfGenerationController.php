<?php

namespace Vanguard\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Barryvdh\DomPDF\Facade\Pdf;
use Vanguard\Attendance;
use Vanguard\EmployeeSalary;
use Vanguard\User;
use Vanguard\UserProfile;

class PdfGenerationController extends Controller
{
    /**
     * monthWiseSalary
     */
    public function monthWiseSalary($office, $year_month)
    {
        $usersBasedOnPlaceOfPosting = UserProfile::where('place_of_posting', $office)->get();

        $salaryPaidUsers = [];

        foreach ($usersBasedOnPlaceOfPosting as $user) {
            $salaryPaidUser = EmployeeSalary::where('user_id', $user->user_id)->where('paid_year_month', $year_month)->where('payment_status', 'paid')->first();

            if ($salaryPaidUser !== null) {
                $salaryPaidUsers[] = $salaryPaidUser;
            }
        }

        $pdf = Pdf::loadView('user.pdf.monthly-salary', compact('office', 'year_month', 'salaryPaidUsers'))->setPaper('a4', 'landscape');
        return $pdf->download($office.'-'.$year_month.'-'.'salary'.'-'.time().'.pdf');
    }

    /**
     * reportSummary
     */
    public function reportSummary($fromDate, $toDate)
    {
        $from = $fromDate;
        $to = $toDate;

        
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


        $pdf = Pdf::loadView('user.pdf.date-wise-report', compact('distinctUserIds', 'from', 'to', 'totalPresent', 'totalAbsent', 'totalLate', 'totalEarly'))->setPaper('a4', 'landscape');
        return $pdf->download($from . ' to ' . $to . ' attendance summary report ' . time() . '.pdf');
    }

}
