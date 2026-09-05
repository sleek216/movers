<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('admin_user')) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'ResponseCode' => '401',
                    'Result' => 'false',
                    'message' => 'Session expired. Please login again.',
                    'action' => route('admin.login')
                ], 401);
            }
            return redirect()->route('admin.login')->with('error', 'Please login to access the admin panel.');
        }

        return $next($request);
    }
}
