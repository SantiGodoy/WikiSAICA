<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class AdminMiddleware
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
    	if ($request->user() && $request->user()->role != 'admin')
			{
        $departments = DB::table('departments')->orderBy('name', 'asc')->get();
				return new Response(view('index', compact('departments')));
			}

		return $next($request);
    }
}
