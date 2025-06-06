<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
{
    public $user;


    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('sanctum')->user();
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $permissions = DB::table('role_has_permissions')
        //     ->select('permissions.name as permission_name')
        //     ->leftJoin('permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
        //     ->leftJoin('users', 'role_has_permissions.role_id', '=', 'users.id')
        //     ->get();

        // $hasAdminRolesIndexPermission = $permissions->contains('permission_name', 'admin.roles.index');

        // if (is_null($this->user) || !$hasAdminRolesIndexPermission) {
        //     abort(403, 'Sorry !! You are Unauthorized to index any role !');
        // }

        // dd($hasAdminRolesIndexPermission);

        // if (is_null($this->user) || !$this->user->can('admin.roles.index')) {
        //     abort(403, 'Sorry !! You are Unauthorized to index any role !');
        // }

        $roles = Role::all();
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // if (is_null($this->user) || !$this->user->can('roles.create')) {
        //     abort(403, 'Sorry !! You are Unauthorized to create any role !');
        // }

        $all_permissions  = Permission::all();
        $permission_groups = User::getpermissionGroups();
        return view('admin.roles.create', compact('all_permissions', 'permission_groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // if (is_null($this->user) || !$this->user->can('roles.create')) {
        //     abort(403, 'Sorry !! You are Unauthorized to create any role !');
        // }

        // Validation Data
        $request->validate([
            'name' => 'required|max:100|unique:roles'
        ], [
            'name.requried' => 'Please give a role name'
        ]);

        // Process Data
        $role = Role::create(['name' => $request->name, 'guard_name' => 'sanctum']);

        // $role = DB::table('roles')->where('name', $request->name)->first();
        $permissions = $request->input('permissions');

        if (!empty($permissions)) {
            $role->syncPermissions($permissions);
        }

        session()->flash('success', 'Role has been created !!');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        // if (is_null($this->user) || !$this->user->can('roles.edit')) {
        //     abort(403, 'Sorry !! You are Unauthorized to edit any role !');
        // }

        $role = Role::findById($id, 'sanctum');
        $all_permissions = Permission::all();
        $permission_groups = User::getpermissionGroups();
        return view('admin.roles.edit', compact('role', 'all_permissions', 'permission_groups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        // if (is_null($this->user) || !$this->user->can('roles.edit')) {
        //     abort(403, 'Sorry !! You are Unauthorized to edit any role !');
        // }

        // TODO: You can delete this in your local. This is for heroku publish.
        // This is only for Super Admin role,
        // so that no-one could delete or disable it by somehow.
        // if ($id === 1) {
        //     session()->flash('error', 'Sorry !! You are not authorized to edit this role !');
        //     return back();
        // }

        // Validation Data
        $request->validate([
            'name' => 'required|max:100|unique:roles,name,' . $id
        ], [
            'name.requried' => 'Please give a role name'
        ]);

        $role = Role::findById($id, 'sanctum');
        $permissions = $request->input('permissions');

        if (!empty($permissions)) {
            $role->name = $request->name;
            $role->save();
            $role->syncPermissions($permissions);
        }

        session()->flash('success', 'Role has been updated !!');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        // if (is_null($this->user) || !$this->user->can('roles.delete')) {
        //     abort(403, 'Sorry !! You are Unauthorized to delete any role !');
        // }

        // TODO: You can delete this in your local. This is for heroku publish.
        // This is only for Super Admin role,
        // so that no-one could delete or disable it by somehow.
        // if ($id === 1) {
        //     session()->flash('error', 'Sorry !! You are not authorized to delete this role !');
        //     return back();
        // }

        // $role = Role::findById($id, 'sanctum');
        // if (!is_null($role)) {
        //     $role->delete();
        // }


        Role::where('id', $id)->delete();

        session()->flash('success', 'Role has been deleted !!');
        return back();
    }
}
