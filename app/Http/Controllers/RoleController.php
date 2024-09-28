<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Auth;



class RoleController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'role']);
            return $next($request);
        });
    }
        /////////////////////////////////////////// 
    public function index() {
        // dd(Auth::user()->roles);
        // return Auth::user()->hasPermission('product.add');
        $roles = Role::all();
        return view('admin.role.index', compact('roles'));
    }
    
    public function add () {
        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode('.', $permission->slug)[0];
        });
        return view('admin.role.add', compact('permissions'));
    }
    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|unique:roles,name',
            'description' => 'required',
            'permission_id' => 'nullable|array',
            'permission_id.*' => 'exists:permissions,id',
        ]);
        $role = Role::create([
            'name' => $request->input('name'),
            'description' => $request->input('description')
        ]);
        $role->permissions()->attach(id: $request->input('permission_id'));
        return redirect()->route('role.index')->with('status_success', 'Bạn đã thêm vai trò thành công =))');
    }

    public function edit(Role $role) {
        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode('.', $permission->slug)[0];
        });
        return view('admin.role.edit', compact('permissions', 'role'));
    }
    public function update(Request $request, Role $role) {
        $validated = $request->validate([
            'name' => 'required|unique:roles,name,'.$role->id,
            'description' => 'required',
            'permission_id' => 'nullable|array',
            'permission_id.*' => 'exists:permissions,id',
        ]);
        $role->update([
            'name' => $request->input('name'),
            'description' => $request->input('description')
        ]);
        $role->permissions()->sync($request->input('permission_id', []));
        return redirect()->route('role.index')->with('status_success', 'Bạn đã cập nhật vai trò thành công =))');
    }

    public function delete(Role $role) {
        $role->delete();
        return redirect()->route('role.index')->with('status_success', 'Bạn đã xóa vai trò thành công =))');
    }
}
