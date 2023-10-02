<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class VerifyCAS
{

    protected $auth;
    protected $cas;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
        $this->cas = app('cas');
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$this->cas->isAuthenticated() && ($request->ajax() || $request->wantsJson())) {
            return response('Unauthorized.', 401);
        }

        if ($this->cas->checkAuthentication()) {
            // Store the user credentials in a Laravel managed session
            if (!cas()->user()) {
                session()->put('cas_user', $this->cas->user());
            }
            $authUser = Auth::user();
            if (!$authUser || $authUser->username != cas()->user()) {
                $user = User::where('username', cas()->user())->first();
                if (!$user) {
                    abort(Response::HTTP_FORBIDDEN, "You don't have permission to access!");
                }
                Auth::login($user);
            }
        } else {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            }
            $this->cas->authenticate();
        }

        return $next($request);
    }
}
