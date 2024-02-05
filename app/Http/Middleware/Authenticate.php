<?php

namespace Vanguard\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Authenticate
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
        if(!$guard){
            if ($this->auth->guest()) {
//                Log::info(dd($this->auth));
                return $request->expectsJson()
                    ? response('Unauthorized.', 401)
                    : redirect()->guest('login');
            }
        }else{
//            if($guard === 'api'){
//                return response('Unauthorized.', 401);
//            }else{
                if (!Auth::guard($guard)->check()) {
                    if ($guard === 'web')
                        return $request->expectsJson()
                            ? response('Unauthorized.', 401)
                            : redirect('/admin/login');
                    else
                        return $request->expectsJson()
                            ? response('Unauthorized.', 401)
                            : redirect('/login');
                }
        }
        return $next($request);
    }
}
