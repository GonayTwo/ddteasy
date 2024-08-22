<?php

namespace App\Http\Middleware\Auth;

use App\Models\Admin\Admin;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || get_class(Auth::user()->userable) != Admin::class) {
            Auth::logout();

            return redirect()->route('filament.admin.auth.login');
        }

        return $next($request);
    }
}
