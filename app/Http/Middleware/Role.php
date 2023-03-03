<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        // dd($role);
        // dd($request->user()->hasRole($role));
        if (! $request->user()->hasRole($role)) {
            alert("У вас нет разрешения на доступ к этой странице.", "", "error");
            return redirect()->route('home');
        }

        return $next($request);
    }
}
