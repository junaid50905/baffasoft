<?php

namespace Vanguard\Http\Controllers\Web\Member;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Requests\Auth\RegisterRequest;
use Vanguard\Http\Requests\Member\MemberRequest;
use Vanguard\Member;
use Vanguard\Repositories\Role\RoleRepository;
use Vanguard\Repositories\User\UserRepository;
use Vanguard\Support\Enum\UserStatus;

class RegisterController extends Controller
{
    /**
     * @var UserRepository
     */
    private $users;

    /**
     * Create a new authentication controller instance.
     * @param UserRepository $users
     */
    public function __construct(UserRepository $users)
    {
        //$this->middleware('registration')->only('show', 'register');

        $this->users = $users;
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('member.register', [
            'socialProviders' => config('auth.social.providers')
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param RegisterRequest $request
     * @param RoleRepository $roles
     * @return \Illuminate\Http\Response
     */
    public function register(MemberRequest $request)
    {
        $member = new Member();
        $member->email = $request->email;
        $member->username = $request->username;
        $member->password = $request->password;
        $member->status = UserStatus::ACTIVE;
        $member = ['email'=>$request->email,'username'=>$request->username,'password'=>$request->password];
        Session::put('member_data',$member);
        Cache::put('member_data', $member);
//        $member->save();

//        return Session::get('member_data');

//
//        event(new Registered($user));
//
//        $message = setting('reg_email_confirmation')
//            ? __('Your account is created successfully! Please confirm your email.')
//            : __('Your account is created successfully!');
//
//        \Auth::login($user);
//
        return redirect()->route('member-details.new');

//        return redirect('/member-details/new')->with('success', 'Member Created Successfully');
//        return redirect('/')->with('Member Created Successfully', $message);
    }
}
