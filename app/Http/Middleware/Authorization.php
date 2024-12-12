<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Authorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = str_replace('Bearer ', '', request()->header('Authorization'));

        if ($this->checkToken($token)) {
            return $next($request);
        } else {
            return redirect('/404');
        }
    }

    public function checkToken($token)
    {
        $result = DB::table('personal_access_tokens')
            ->where('token', $token)
            ->where('expires_at', '>', now())
            ->first();

        if ($result) {
            return true;
        }

        return false;
    }
}
