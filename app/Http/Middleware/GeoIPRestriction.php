<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class GeoIPRestriction
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $allowedCountries = ['US', 'IN', 'USA']; // USA and India

        $ip = $request->ip();
        $json = file_get_contents("http://ipinfo.io/{$ip}/geo");
        $json = json_decode($json, true);

        if (isset($json['country']) && !in_array($json['country'], $allowedCountries)) {
            return response('Access Denied', 403);
        }

        return $next($request);
    }
}
