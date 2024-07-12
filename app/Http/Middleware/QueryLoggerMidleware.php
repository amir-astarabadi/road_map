<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class QueryLoggerMidleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }
    
    
    public function terminate($request)
    {
    // dd(global(LARAVEL_START));
        DB::listen(function($query) use($request){
            Log::channel('daily')->info($request->fullUrl() . " " . $request->method(), ['sql' => $query->sql, 'time' => $query->time]);
        });
    }
}
