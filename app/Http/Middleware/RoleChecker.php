<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class RoleChecker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $super_admin,$store_manager = null, $manager_assistant = null,$admin =null,$cashier =null,$accountant =null)
    {
        $roles[]=Auth::guard('admin')->user()->role;
        if (in_array($super_admin, $roles)) {
            return $next($request);
        } else if (in_array($admin, $roles)) {
            return $next($request);
        } else if (in_array($manager_assistant, $roles)) {
            return $next($request);
        } else if (in_array($store_manager, $roles)) {
            return $next($request);
        }else if (in_array($cashier, $roles)) {
            return $next($request);
        }else if (in_array($accountant, $roles)) {
            return $next($request);
        }
        return redirect()->back()->withErrors(['error'=>'You Cant Do this Action Permission Denied']);
    }
}
