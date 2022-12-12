<?php

namespace App\Http\Middleware;

use Closure, Cookie;

class CheckDefaultCookies
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function handle($request, Closure $next)
    {
        if(Cookie::get('default_city') !== false){
            Cookie::queue(Cookie::make('default_city', 'Ahmedabad', 120));
        }
        return $next($request);
    }
}
