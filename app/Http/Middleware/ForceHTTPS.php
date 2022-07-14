<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceHTTPS
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
        if (\App::environment('production')) {
            $this->app['request']->server->set('HTTPS', true);
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        return $next($request);
    }
}
