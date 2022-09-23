<?php

namespace TungTT\LaravelGeoNode\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Support\Facades\Auth;
use TungTT\LaravelGeoNode\Facades\GeoNode;

class EnsureGeoNodeTokenIsValid extends AuthenticateSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && GeoNode::user() && GeoNode::tokenExpired()) {
            Auth::logoutCurrentDevice();
            $request->session()->flush();

            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthenticated.'], 401);
            }

            return redirect()->guest(RouteServiceProvider::HOME);
        }

        return $next($request);
    }
}
