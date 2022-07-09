<?php

namespace App\Http\Middleware\api;

use Closure;
use Illuminate\Http\Request;

class NotKeluarga
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
        if (in_array($request->user()->role, ['admin', 'penyuluh', 'bidan'])) {
            return $next($request);
        }

        return response([
            'message' => 'Access Denied.'
        ], 401);
    }
}
