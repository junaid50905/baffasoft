<?php

namespace Vanguard\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if($guard){
            if (Auth::guard($guard)->check()) {
                if ($guard === 'web') {
                    return redirect('/admin');
                }
                return redirect('/member');
            }
        }else{
            if (Auth::guard('web')->check()) {
                return redirect('/admin');
            }elseif(Auth::guard('front')->check()){
                return redirect('/member');
            }else{
                return $next($request);
            }
        }

//        if ($this->auth->check()) {
//            return request()->has('to')
//                ? redirect(request()->get('to'))
//                : redirect('/');
//        }

        return $next($request);
    }
}
