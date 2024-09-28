<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class AdminMenuController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'menu']);
            return $next($request);
        });
    }

    //////////////////////////
    function list(Request $request)
    {
        $status = $request->input('menu_status');
        if ($status == 'published') {
            $menu = Menu::where('menu_status', '=', "published")->orderBy('updated_at', 'desc')->paginate(10);
        } elseif ($status == 'draft') {
            $menu = Menu::where('menu_status', '=', "draft")->orderBy('updated_at', 'desc')->paginate(10);
        } else {
            $keyword = '';
            if ($request->input('keyword')) {
                $keyword = $request->input('keyword');
            }
            $menu = Menu::where('menu_title', 'LIKE', "%{$keyword}%")->orderBy('updated_at', 'desc')->paginate(10);
        }

        $count_all = Menu::count();
        $count_published = Menu::where('menu_status', '=', 'published')->count();
        $count_draft = Menu::where('menu_status', '=', 'draft')->count();
        $count = [$count_all, $count_published, $count_draft];

        return view('admin.menu.list', compact('menu', 'count'));
    }

    function add(Request $request) {

        return view('admin.menu.add');
    }
    function store(Request $request) {
        $request->validate(
            [
                'menu_title' => 'required|string|max:255',
                'menu_url' => 'required|string|max:255',
                'menu_status' => 'required|in:draft,published'
            ],
            [
                'required' => ':attribute Không được để trống !!!',
                'min' => ':attribute Có độ dài ít nhất :min ký tự !!!',
                'max' => ':attribute Có độ dài tối đa :max ký tự !!!',
            ],
            [
                'menu_title' => 'Tên menu',
                'menu_url' => 'Link menu',
                'menu_status' => 'Trạng thái', 
                'creator' => 'Người tạo',
                'update_at' => 'Ngày cập nhật',
            ]      
        );
        Menu::create([
                'menu_title' => $request->input('menu_title'),
                'menu_url' => $request->input('menu_url'),
                'menu_status' => $request->input('menu_status'), 
                'creator' => Auth::user()->name,
                'user_id' => auth()->user()->id,
                'page_id' => $request->input(''),
                // 'updated_at' => $request->input(''),
        ]);
        return redirect('admin/menu/list')->with('status_success', 'Bạn đã thêm menu thành công =))'); 
    }

    function edit(Request $request, $menu_id) {
        $menu = Menu::find($menu_id);   
        return view('admin.menu.edit', compact('menu'));
    }
    function update(Request $request, $menu_id) {
        $request->validate(
            [
                'menu_title' => 'required|string|max:255',
                'menu_url' => 'required|string|max:255',
                'menu_status' => 'required|in:draft,published'
            ],
            [
                'required' => ':attribute Không được để trống !!!',
                'min' => ':attribute Có độ dài ít nhất :min ký tự !!!',
                'max' => ':attribute Có độ dài tối đa :max ký tự !!!',
            ],
            [
                'menu_title' => 'Tên menu',
                'menu_url' => 'Link menu',
                'menu_status' => 'Trạng thái', 
                'creator' => 'Người tạo',
                'update_at' => 'Ngày cập nhật',
            ]      
        );
        Menu::where('menu_id', $menu_id)->update([
                'menu_title' => $request->input('menu_title'),
                'menu_url' => $request->input('menu_url'),
                'menu_status' => $request->input('menu_status'), 
                'creator' => Auth::user()->name,
                'user_id' => auth()->user()->id,
        ]);
        return redirect('admin/menu/list')->with('status_success', 'Bạn đã cập nhật menu thành công =))'); 
    }
    function delete(Request $request, $menu_id) {
        $menu = Menu::find($menu_id);
        $menu->delete();
        return redirect('admin/menu/list')->with('status_success', 'Bạn đã xóa bảng ghi thành công =))');
    }
    
}
