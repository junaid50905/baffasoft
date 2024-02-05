<?php

namespace Vanguard\Http\Controllers\Web\Member;

use Auth;
use Authy;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Vanguard\Events\Member\LoggedIn;
use Vanguard\Events\Member\LoggedOut;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Member;
use Vanguard\Repositories\Member\MemberRepository;
use Vanguard\Services\Auth\ThrottlesLogins;
use Vanguard\Services\Auth\TwoFactor\Contracts\Authenticatable;
use DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    use ThrottlesLogins;

    /**
     * @var MemberRepository
     */
    private $members;

    /**
     * Create a new authentication controller instance.
     * @param MemberRepository $users
     */
    public function __construct(MemberRepository $members)
    {
        $this->middleware('guest')->except('member_logout');
//        $this->middleware('guest:web')->except('member_logout');
//        $this->middleware('guest:front')->except('member_logout');
//        $this->middleware('auth')->only('member_logout');

        $this->members = $members;
    }

    public function username()
    {
        return 'username';
    }

    /**
     * Show the application login form.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        return view('member.login', [
            'socialProviders' => config('auth.social.providers')
        ]);
    }

    /**
     * @param LoginRequest $request
     * @return RedirectResponse|Response
     * @throws BindingResolutionException
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);


        $credentials = $request->only('username', 'password');
        $user = Auth::guard('front')->getProvider()->retrieveByCredentials($credentials);
        if($user){
            if ($user->isBanned()) {
                return redirect()->to('login')
                    ->withErrors(__('Your account is banned by administrator.'));
            }
        }
// LoginRequest $request
//        $credentials = $request->getCredentials();
//        if(!Auth::validate($credentials)):
//            return redirect()->to('login')
//                ->withErrors(trans('auth.failed'));
//        endif;
//        $user = Auth::getProvider()->retrieveByCredentials($credentials);
//        Auth::login($user);
//        return $this->authenticated($request, $user);


//        if(Auth::guard('front')->attempt($credentials)){      // Auth::validate($credentials)
//            return redirect()->route('member.dashboard');
//        }else{
//            return redirect('/')->withErrors('Invalid Credential');
//        }


//        var_dump($credentials)  ;
//        exit();

//        if (Auth::guard('front')->attempt(['email' => $credentials['email'], 'password' => $credentials['password']], $request->get('remember'))) {
        if (Auth::guard('front')->attempt(['username' => $credentials['username'], 'password' => $credentials['password']], $request->get('remember'))) {
//            $member = Auth::guard('front')->getProvider()->retrieveByCredentials($credentials);
//            Auth::guard('front')->login($member, setting('remember_me') && $request->get('remember'));
//            echo 'ASI';
//            $member = Auth::guard('front')->user();
//            var_dump($member);
//            exit;

//            if(auth('front')->user()->username == 'member'){
                return redirect()->to('member/home');
//            }
//            return redirect('member')->withSuccess('You have Successfully loggedin');
        }
        /*$member = DB::table('members')->where('email', $credentials['email'])->first();
        if($member) {
            if (Hash::check($credentials['password'], $member->password)) {
                //var_dump($member);
                //exit;
                event(new LoggedIn);
                return redirect()->intended('member')
                    ->withSuccess('You have Successfully loggedin');
            }
        }*/

        return redirect("login")->withErrors('Oppes! You have entered invalid credentials');
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  Request $request
     * @param  bool $throttles
     * @param $user
     * @return RedirectResponse|Response
     */
    protected function authenticated(Request $request, $throttles, $user)
    {
        if ($throttles) {
            $this->clearLoginAttempts($request);
        }

        if (setting('2fa.enabled') && Authy::isEnabled($user)) {
            return $this->logoutAndRedirectToTokenPage($request, $user);
        }

        event(new LoggedIn);

        if ($request->has('to')) {
            return redirect()->to($request->get('to'));
        }

        return redirect()->intended('member');
    }

    /**
     * @param Request $request
     * @param Authenticatable $user
     * @return RedirectResponse
     */
    protected function logoutAndRedirectToTokenPage(Request $request, Authenticatable $member)
    {
        Auth::guard('front')->logout();

        $request->session()->put('auth.2fa.id', $member->id);

        return redirect()->route('auth.token');
    }

    /**
     * Log the user out of the application.
     *
     * @return RedirectResponse|\Illuminate\Routing\Redirector
     */

    public function member_logout(){
        Auth::guard('front')->logout();
//        var_dump(Auth::guard('front')->check());
        return redirect('login');
    }
}
