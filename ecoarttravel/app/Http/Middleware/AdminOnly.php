<?php namespace App\Http\Middleware;

use App\UserType;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\RedirectResponse;

class AdminOnly {

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
    public function handle($request, Closure $next)
    {
        if ($this->auth->user()->user_type_id == UserType::GUIDE)
        {
            if ($request->ajax())
            {
                return response('Unauthorized.', 401);
            }

            return redirect('/admin/tour-assignment-calendar');
        }

        return $next($request);
    }

}