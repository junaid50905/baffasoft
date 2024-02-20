<?php

namespace Vanguard\Http\Controllers;

use Illuminate\Http\Request;
use Vanguard\LeaveAllocation;
use Vanguard\LeaveApplication;
use Vanguard\User;
use Carbon\Carbon;
use DB;
use Vanguard\ApprovedDeclinedLeave;

class LeaveController extends Controller
{
    // allocateLeave
    public function allocateLeave($user)
    {
        $userId = $user->id;

        $allocated_leave = LeaveAllocation::where('user_id', $user->id)->first();
        return view('user.leave.allocate-leave', compact('allocated_leave', 'userId'));
    }
    // allocateLeaveStore
    public function allocateLeaveStore(Request $request, $userId)
    {
        $request->validate([
            'casual_leave_allowed' => 'required',
            'sick_leave_allowed' => 'required',
            'annual_leave_allowed'=> 'required',
            'maternity_leave_allowed' => 'required',
            'paternity_leave_allowed' => 'required'
        ]);

        LeaveAllocation::insert([
            'user_id' => $userId,
            'casual_leave_allowed' => $request->casual_leave_allowed,
            'sick_leave_allowed' => $request->sick_leave_allowed,
            'annual_leave_allowed' => $request->annual_leave_allowed,
            'maternity_leave_allowed' => $request->maternity_leave_allowed,
            'paternity_leave_allowed' => $request->paternity_leave_allowed
        ]);

        return redirect()->back();
    }

    // index
    public function index()
    {
        $user = auth()->user()->id;
        $myApplications = LeaveApplication::where('user_id', $user)->get();
        return view('user.leave.index', compact('myApplications'));
    }
    // create
    public function create()
    {
        $users = User::all();

        $authUserId = auth()->user()->id;

        // $myApplications = LeaveApplication::where('user_id', $authUserId)->get();

        // if (LeaveAllocation::where('user_id', $user)->exists()) {
        //     $allowedLeave = LeaveAllocation::where('user_id', $user)->first();
        // }

        $allowedLeave = LeaveAllocation::where('user_id', $authUserId)->first();

        return view('user.leave.create', compact('users', 'allowedLeave', 'authUserId'));
    }

    // store
    public function store(Request $request, $user)
    {
        $request->validate([
            'manager_id' => 'required',
            'leave_type' => 'required',
            'leave_from' => 'required',
            'leave_to' => 'required',
            'purpose' => 'required',
        ]);

        $date1 = Carbon::create($request->leave_from);
        $date2 = Carbon::create($request->leave_to);

        $leaveDays = $date1->diffInDays($date2) + 1;

        LeaveApplication::insert([
            'user_id' => $user->id,
            'manager_id' => $request->manager_id,
            'leave_type' => $request->leave_type,
            'leave_from' => $request->leave_from,
            'leave_to' => $request->leave_to,
            'leave_days' => $leaveDays,
            'purpose' => $request->purpose,
            'status' => 'pending',
        ]);

        return redirect()->route('leave.index');
    }
    // viewMyAppliedApplication
    public function viewMyAppliedApplication($id)
    {
        $approvedMyLeave = ApprovedDeclinedLeave::where('leave_application_id', $id)->first();
        return view('user.leave.view-my-applied-application', compact('approvedMyLeave'));
    }
    // newApplication
    public function appliedToMe()
    {
        $authUser = auth()->user()->id;
        $appliedToMe = LeaveApplication::where('manager_id', $authUser)->get();


        return view('user.leave.applied-to-me', compact('appliedToMe'));
    }
    // viewAppliedApplication
    public function viewAppliedApplication($applicationId)
    {
        $application = LeaveApplication::where('id', $applicationId)->first();

        return view('user.leave.view-applied-application', compact('application'));
    }
    // storeAppliedApplication
    public function storeAppliedApplication(Request $request, $applicationId)
    {
        // dd($request->all());
        // // approved_decline_leaves
        // DB::table('approved_decline_leaves')->insert([
        //     'leave_application_id ' => $request->leave_application_id,
        //     'user_id  ' => $request->user_id,
        //     'casual_leave' => $request->casual_leave,
        //     'sick_leave' => $request->sick_leave,
        //     'annual_leave' => $request->annual_leave,
        //     'maternity_leave' => $request->maternity_leave,
        //     'paternity_leave' => $request->paternity_leave,
        //     'special_leave' => $request->special_leave,
        //     'annual_leave_total' => $request->annual_leave_total,
        //     'status' => $request->status,
        // ]);
        $approved_days = $request->casual_leave + $request->sick_leave + $request->annual_leave + $request->maternity_leave + $request->paternity_leave + $request->special_leave + $request->annual_leave_total;
        ApprovedDeclinedLeave::insert([
            'leave_application_id' => $request->leave_application_id,
            'user_id' => $request->user_id,
            'casual_leave' => $request->casual_leave,
            'sick_leave' => $request->sick_leave,
            'annual_leave' => $request->annual_leave,
            'maternity_leave' => $request->maternity_leave,
            'paternity_leave' => $request->paternity_leave,
            'special_leave' => $request->special_leave,
            'annual_leave_total' => $request->annual_leave_total,
            'approved_days' => $approved_days,
            'status' => $request->status,
        ]);

        // leave_applications
        LeaveApplication::where('id', $applicationId)->update([
            'status' => $request->status
        ]);

        // leave_allocations
        $leaveAllowcation = LeaveAllocation::where('user_id', $request->user_id)->first();

        $enjoyed_cl = $leaveAllowcation->casual_leave_enjoyed;
        $enjoyed_sl = $leaveAllowcation->sick_leave_enjoyed;
        $enjoyed_al = $leaveAllowcation->annual_leave_enjoyed;
        $enjoyed_ml = $leaveAllowcation->maternity_leave_enjoyed;
        $enjoyed_pl = $leaveAllowcation->paternity_leave_enjoyed;
        $enjoyed_alt = $leaveAllowcation->annual_leave_total_enjoyed;
        $enjoyed_spl = $leaveAllowcation->special_leave_enjoyed;

        $balance_cl = $leaveAllowcation->casual_leave_balance;
        $balance_sl = $leaveAllowcation->sick_leave_balance;
        $balance_al = $leaveAllowcation->annual_leave_balance;
        $balance_ml = $leaveAllowcation->maternity_leave_balance;
        $balance_pl = $leaveAllowcation->paternity_leave_balance;
        $balance_alt = $leaveAllowcation->annual_leave_total_balance;


        LeaveAllocation::where('user_id', $request->user_id)->update([

            'casual_leave_enjoyed' => $enjoyed_cl + $request->casual_leave,
            'sick_leave_enjoyed' => $enjoyed_sl + $request->sick_leave,
            'annual_leave_enjoyed' => $enjoyed_al + $request->annual_leave,
            'maternity_leave_enjoyed' => $enjoyed_ml + $request->maternity_leave,
            'paternity_leave_enjoyed' => $enjoyed_pl + $request->paternity_leave,
            'annual_leave_total_enjoyed' => $enjoyed_alt + $request->annual_leave_total,
            'special_leave_enjoyed' => $enjoyed_spl + $request->special_leave,

            'casual_leave_balance' => $balance_cl - $request->casual_leave,
            'sick_leave_balance' => $balance_sl - $request->sick_leave,
            'annual_leave_balance' => $balance_al - $request->annual_leave,
            'maternity_leave_balance' => $balance_ml - $request->maternity_leave,
            'paternity_leave_balance' => $balance_pl - $request->paternity_leave,
            'annual_leave_total_balance' => $balance_alt - $request->annual_leave_total,

        ]);

        return redirect()->route('leave.applied.to.me');
    }
    // allApplication
    public function allApplication()
    {
        $allApplication = LeaveApplication::orderBy('id', 'desc')->get();
        return view('user.leave.all-applications', compact('allApplication'));
    }
}
