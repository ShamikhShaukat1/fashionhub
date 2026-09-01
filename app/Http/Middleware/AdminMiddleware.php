<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {

        /*
        |--------------------------------------------------------------------------
        | Make Sure User Is Logged In
        |--------------------------------------------------------------------------
        */

        if (!$request->user()) {
            return redirect()->route('login');
        }


        /*
        |--------------------------------------------------------------------------
        | Check Admin Role
        |--------------------------------------------------------------------------
        */

        if ($request->user()->role !== 'admin') {
            abort(
                403,
                'Unauthorized access. Admin privileges are required.'
            );
        }


        return $next($request);
    }
}
