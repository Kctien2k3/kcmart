<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class AdminUserController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'user']);
            return $next($request);
        });
    }
    public function list(Request $request, Role $role)
    {
        $status = $request->input('status');
        $list_act = [
            'delete' => 'Xóa tạm thời'
        ];
        if ($status == 'trash') {
            $list_act = [
                'restore' => 'Khôi phục',
                'forceDelete' => 'Xóa vĩnh viễn'
            ];
            $users = User::onlyTrashed()->orderBy('updated_at', 'desc')->paginate(10);
        } else {
            $keyword = "";
            if ($request->input('keyword')) {
                $keyword = $request->input('keyword');
            }
            $users = User::where('name', 'LIKE', "%{$keyword}%")->orderBy('updated_at', 'desc')->paginate(10);
        }
        $count_user_active = User::count();
        $count_user_trash = User::onlyTrashed()->count();
        $count = [$count_user_active, $count_user_trash];
        return view('admin.user.list', compact('users', 'count', 'list_act'));
    }
    public function add(Request $request)
    {
        $roles = Role::all();
        return view('admin.user.add', compact('roles'));
    }
    public function store(Request $request, User $user)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'fullname' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
            ],
            [
                'required' => ':attribute Không được để trống !',
                'min' => ':attribute Có độ dài ít nhất :min ký tự !',
                'max' => ':attribute Có độ dài tối đa :max ký tự !',
                // 'confirmed' => 'Xác nhận mật khẩu không trùng khớp !!!'
            ],
            [
                'name' => 'Tên người dùng',
                'fullname' => 'Tên tài khoản',
                'email' => 'Email',
                'password' => 'Mật khẩu',
            ]
        );
        // add vào database
        $user = User::create(
            [
                'name' => $request->input('name'),
                'fullname' => $request->input('fullname'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]
        );
        $user->roles()->attach($request->input('roles'));
        return redirect('admin/user/list')->with('status_success', 'Đã thêm User thành công =))');
    }

    public function action(Request $request)
    {
        $list_check = $request->input('list_check');
        // dd($list_check);
        if ($list_check) {
            foreach ($list_check as $key => $id) {
                if (Auth::id() == $id) {
                    unset($list_check[$key]);
                }
            }
            if (!empty($list_check)) {
                $act = $request->input('act');
                if ($act == 'delete') {
                    User::destroy($list_check);
                    return redirect('admin/user/list')->with('status_success', 'Bản ghi đã được đưa vào thùng rác =))');
                }
                if ($act == 'restore') {
                    User::withTrashed()
                        ->whereIn('id', $list_check)
                        ->restore();
                    return redirect('admin/user/list')->with('status_success', 'Bạn đã khôi phục bản ghi thành công =))');
                }
                if ($act == 'forceDelete') {
                    User::withTrashed()
                        ->whereIn('id', $list_check)
                        ->forceDelete();
                    return redirect('admin/user/list')->with('status_success', 'Bạn đã xóa vĩnh viễn bản ghi thành công =))');
                }
            }
            return redirect('admin/user/list')->with('status_danger', 'Bạn không thể xóa bản thân khỏi tài khoản !');

        } else {
            return redirect('admin/user/list')->with('status_danger', 'Bạn chưa chọn đối tượng cần thực hiện !');
        }

    }
    public function delete(Request $request, $id)
    {
        if (Auth::id() != $id) {
            $user = User::find($id);
            if ($user) {
                $user->delete();
                return redirect('admin/user/list')->with('status_success', 'Bản ghi đã được đưa vào thùng rác =))');
            } else {
                $user = User::onlyTrashed()->find($id);
                $user->forceDelete();
                return redirect('admin/user/list')->with('status_success', 'Bạn đã xóa bảng ghi thành công =))');
            }
        } else {
            return redirect('admin/user/list')->with('status_danger', 'Không thể xóa bản thân khỏi tài khoản !');
        }
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.user.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate(
            [
                'fullname' => 'required|string|max:255',
                'name' => 'required|string|max:255',
                // 'password'=> 'required|string|min:8',
            ],
            [
                'required' => ':attribute Không được để trống !!!',
                'min' => ':attribute Có độ dài ít nhất :min ký tự !!!',
                'max' => ':attribute Có độ dài tối đa :max ký tự !!!',
                // 'confirmed' => 'Xác nhận mật khẩu không trùng khớp !!!'
            ],
            [
                'fullname' => 'Tên người dùng',
                'name' => 'Tên người dùng',
                'password' => 'Mật khẩu',
            ]
        );
        // add vào database
        $user->update(
            [
                'fullname' => $request->input('fullname'),
                'name' => $request->input('name'),
                // 'password'=> Hash::make($request->input('password')),
            ]
        );
        $user->roles()->sync($request->input('roles'));
        return redirect('admin/user/list')->with('status_success', 'Cập nhật User thành công =))');
    }
}
