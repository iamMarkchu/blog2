<?php

namespace App\Http\Middleware;

use Closure;
use DB;

class Tracking
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        DB::table('pvs')->insert([
                'ip' => $request->server('REMOTE_ADDR'),
                'visit_time' => date('Y-m-d H:i:s'),
                'user_agent' => $request->server('HTTP_USER_AGENT'),
                'referer' => $request->server('HTTP_REFERER'),
                'request_uri' => $request->fullUrl()
            ]);
        return $next($request);
    }
}
