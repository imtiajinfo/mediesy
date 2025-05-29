<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Exceptions\UnauthorizedException;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission = null, $guard = null)
    {
        $user = Auth::user(); // Retrieve the currently authenticated user

        $guardName = Auth::getDefaultDriver();


        // if (Auth::guest()) {
        //     throw UnauthorizedException::notLoggedIn();
        // }


        $route = Route::currentRouteName();

        $permissions = DB::table('role_has_permissions')
            ->select('permissions.name as permission_name')
            ->leftJoin('permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
            ->leftJoin('users', 'role_has_permissions.role_id', '=', 'users.id')
            ->where('permissions.name', $route)
            ->where('permissions.guard_name', 'sanctum')
            ->first();

        $permission_name =  $permissions->permission_name ?? '';

        // dd($permission_name);

        // if ($permission_name == null || $permission_name !== $route) {
        //     // return redirect()->route('admin.dashboard')->with('error', 'Sorry !! You are Unauthorized to index any role !');
        //     abort(403, 'Sorry !! You are Unauthorized to index any role !');
        // }


        // if (!is_null($permission)) {
        //     $permissions = is_array($permission)
        //         ? $permission
        //         : explode('|', $permission);
        // }

        // if (is_null($permission)) {
        //     $permission = $request->route()->getName();
        //     $permissions = array($permission);
        // }


        // foreach ($permissions as $permission) {
        //     if ($authGuard->user()->can($permission)) {
        //         return $next($request);
        //     }

        //     if ($authGuard->user()->hasPermission($permission)) {
        //         return $next($request);
        //     }
        // }

        // throw UnauthorizedException::forPermissions($permissions);



        return $next($request);
    }
}
