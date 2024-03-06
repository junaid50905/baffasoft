<?php

namespace Vanguard\Http\Controllers\Web\Users;

use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Repositories\Session\SessionRepository;
use Vanguard\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Vanguard\Department;
use Vanguard\UserProfile;

/**
 * Class SessionsController
 * @package Vanguard\Http\Controllers\Web\Users
 */
class SessionsController extends Controller
{
    /**
     * @var SessionRepository
     */
    private $sessions;

    /**
     * SessionsController constructor.
     * @param SessionRepository $sessions
     */
    public function __construct(SessionRepository $sessions)
    {
        $this->middleware('permission:users.manage');

        $this->sessions = $sessions;
    }

    /**
     * Displays the list with all active sessions for the selected user.
     *
     * @param User $user
     * @return Factory|View
     */
    public function index(User $user)
    {
        return view('user.sessions', [
            'adminView' => true,
            'user' => $user,
            'sessions' => $this->sessions->getUserSessions($user->id)
        ]);
    }

    /**
     * Invalidate specified session for selected user.
     *
     * @param User $user
     * @param $session
     * @return mixed
     */
    public function destroy(User $user, $session)
    {
        $this->sessions->invalidateSession($session->id);

        return redirect()->route('user.sessions', $user->id)
            ->withSuccess(__('Session invalidated successfully.'));
    }

    /**
     * Updates the user profile
     *
     * @param User $user
     * @return Factory|View
     */
    public function updateProfileShow(User $user)
    {
        $departments = Department::all();

        return view('user.update-profile', [
            'adminView' => true,
            'user' => $user,
            'departments' => $departments,
            'sessions' => $this->sessions->getUserSessions($user->id)
        ]);

    }

    public function updateProfile(Request $request, $user)
    {
        $data = [
            'user_id' => $user->id,
            'department_id' => $request->department_id,
            'place_of_posting' => $request->place_of_posting,
            'designation' => $request->designation,
            'job_status' => $request->job_status,
            'joining_date' => $request->joining_date,
            'confirmation_date' => $request->confirmation_date,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'emergancy_contact' => $request->emergancy_contact,
            'blood_group' => $request->blood_group,
            'last_education' => $request->last_education,
            'years_of_experience' => $request->years_of_experience,
            'present_address' => $request->present_address,
            'permanent_address' => $request->permanent_address,
            'date_of_promotion' => $request->date_of_promotion,
        ];

        if(UserProfile::where('user_id', $user->id)->exists()){
            UserProfile::where('user_id', $user->id)->update($data);
        }else{
            UserProfile::insert($data);
        }

        return redirect()->to('admin/users');



    }
}
