<?php

namespace App\Http\Middleware\Auth;

use App\Models\Customers\Customer;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CustomerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || get_class(Auth::user()->userable) != Customer::class) {
            Auth::logout();
            session()->put('url.intended', $request->url());

            return redirect()->route('site.auth.login');
        }

        return $next($request);
    }
}
