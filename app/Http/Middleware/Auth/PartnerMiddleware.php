<?php

namespace App\Http\Middleware\Auth;

use App\Models\Partners\Partner;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PartnerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || get_class(Auth::user()->userable) != Partner::class) {
            Auth::logout();

            return redirect()->back();
        }

        return $next($request);
    }
}
