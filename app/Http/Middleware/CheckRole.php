<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,  ...$roles): Response
    {
        if(!$request->user()){
            return redirect('login');
        }

        $userRoles = $request->user()->roles->pluck('name')->toArray();

    //     dump($userRoles); // Lihat isi role user
    // dump($roles);     // Lihat isi role dari route
    // dd(array_intersect($userRoles, $roles));

        if(array_intersect($roles, $userRoles)){
            return $next($request);
        }

        abort(403, 'Anda tidak memiliki otoritas untuk mengakses halaman ini.');
    }
}
