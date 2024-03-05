<?php

namespace App\Http\Middleware;
use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AccessRight
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $access)
    {
        $role = Auth::user()->role;
        if($role == 'super_admin'){
            return $next($request);
        }

        $role = Role::where('alias', $role)->first();
        if(!empty($role)){
            $right = json_decode($role->access_rights);
            $check = in_array($access, $right);
            if($check){
                return $next($request);
            }
        }
        \Session::flash('danger', 'Access Denied: You are not authorized to access this section. Please contact your administrator for assistance!');
        return redirect()->route('admin.dashboard');
    }
}
