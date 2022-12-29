<?php

namespace App\Http\Middleware;

use Botble\Theme\Contracts\Theme;

use Closure;
use Illuminate\Http\Request;

class ComingSoonMiddleware
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
    //    return view('comingSoon');
    $html ="<div>
    <center>
    <h1 >Coming Soon....</h1>
    </center>
</div>";

echo $html;die;

        dd(11);
        return $next($request);
    }
}
