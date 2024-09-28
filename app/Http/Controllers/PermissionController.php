<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;


class PermissionController extends Controller
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
    public function add()
    {
        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode('.', $permission->slug)[0];
        });
        return view('admin.permission.add', compact('permissions'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => 'required|max:255',
                'slug' => 'required',
            ]
        );
        Permission::create(
            [
                'name' => $request->input('name'),
                'slug' => $request->input('slug'),
                'description' => $request->input('description'),
            ]
        );
        return redirect()->route('permission.add')->with('status_success', 'Bạn đã thêm quyền thành công =))');
    }
    public function edit(Request $request, $id)
    {
        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode('.', $permission->slug)[0];
        });
        $permission = Permission::find($id);
        return view('admin.permission.edit', compact('permissions', 'permission'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate(
            [
                'name' => 'required|max:255',
                'slug' => 'required',
            ]
        );
        Permission::where('id', $id)->update(
            [
                'name' => $request->input('name'),
                'slug' => $request->input('slug'),
                'description' => $request->input('description'),
            ]
        );
        return redirect()->route('permission.add')->with('status_success', 'Bạn đã chỉnh sửa quyền thành công =))');
    }

    public function delete($id) {
        Permission::where('id', $id) 
        ->delete();
        return redirect()->route('permission.add')->with('status_success', 'Bạn đã xóa quyền thành công =))');
    }
}
