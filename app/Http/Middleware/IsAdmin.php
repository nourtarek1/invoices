<?php

namespace App\Http\Middleware;

use Closure;
use App\Traits\HasRolesAndPermissions;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;


class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()->type=='admin') {
            return $next($request);
        } else {
            Auth::logout();
            return redirect()->route('index');
        }
    }
}
