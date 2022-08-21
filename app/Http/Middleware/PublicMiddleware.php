<?php

namespace App\Http\Middleware;

use App\Models\Configuration;
use Closure;
use Illuminate\Http\Request;

class PublicMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $hide_from_public = Configuration::get("hide_from_public");
        if ($hide_from_public && $hide_from_public == "true") {
            return redirect()->route("vote.private");
        } else {
            return $next($request);
        }
    }
}
