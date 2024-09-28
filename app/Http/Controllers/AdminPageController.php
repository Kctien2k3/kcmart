<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Slug;
use RealRashid\SweetAlert\Facades\Alert;



class AdminPageController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'page']);
            return $next($request);
        });
    }
    public function list(Request $request)
    {
        // $pages = null;
        $status = $request->input('status');
        $list_act = [
            'delete' => 'xóa tạm thời'
        ];
        if ($status == "trash") {
            $list_act = [
                'restore' => 'khôi phục',
                'forceDelete' => 'xóa vĩnh viễn'
            ];
            $pages = Page::onlyTrashed()->orderBy('updated_at', 'desc')->paginate(10);
        } elseif ($status == "draft") {
            $pages = Page::where('page_status', '=', "draft")->orderBy('updated_at', 'desc')->paginate(10);
        } elseif ($status == "published") {
            $pages = Page::where('page_status', '=', "published")->orderBy('updated_at', 'desc')->paginate(10);
        } else {
            $keyword = "";
            if ($request->input('keyword')) {
                $keyword = $request->input('keyword');
            }
            $pages = Page::where('page_title', 'LIKE', "%{$keyword}%")->orderBy('updated_at', 'desc')->paginate(10);
        }
        $count_page_all = Page::count(); 
        $count_page_draft = Page::where('page_status', '=', "draft")->count();
        $count_page_trash = Page::onlyTrashed()->count();
        $count_page_published = Page::where('page_status', '=', "published")->count();
        // dd($pages->total());

        $count = [$count_page_all, $count_page_draft, $count_page_trash, $count_page_published];
        return view('admin.page.list', compact('pages', 'count', 'list_act'));
    }

    public function add(request $request)
    {
        return view('admin.page.add');
    }
    public function store(Request $request)
    {
        $request->validate(
            [
                'page_title' => 'required|string|max:100',
                'page_slug' => 'required|string|max:100',
                'page_content' => 'required|string',
                'page_status' => 'required|in:draft,published'
            ],
            [
                'required' => ':attribute không được để trống !',
                'min' => ':attribute Có độ dài ít nhất :min ký tự !',
                'max' => ':attribute Có độ dài tối đa :max ký tự !',
            ],
            [
                'page_title' => 'Tiêu đề trang',
                'page_slug' => 'Slug trang',
                'page_content' => 'Nội dung trang',
                'page_status' => 'Trạng thái'
            ]
        );

        Page::create(
            [
                'page_title' => $request->input('page_title'),
                'page_slug' => Slug::create_slug($request->input('page_slug')),
                'page_content' => $request->input('page_content'),
                'page_status' => $request->input('page_status'),
                'user_id' => auth()->user()->id,
            ]
        );
        return redirect('admin/page/list')->with('status_success', 'Bạn đã thêm trang thành công =))');
    }



    public function delete(Request $request, $page_id)
    {
        $status = $request->input('status');
        if ($status == 'trash') {
            $page = Page::onlyTrashed()->find($page_id);
            $page->forceDelete();
            return redirect('admin/page/list')->with('status_success', 'Bạn đã xóa bảng ghi thành công =))');
        } else {
            $page = Page::find($page_id);
            if ($page) {
                $page->delete();
                return redirect('admin/page/list')->with('status_success', 'Bản ghi đã được đưa vào thùng rác =))');
            } else {
                $page = Page::onlyTrashed()->find($page_id);
                $page->forceDelete();
                return redirect('admin/page/list')->with('status_success', 'Bạn đã xóa bảng ghi thành công =))');
            }
        }

    }
    public function action(Request $request)
    {

        $list_check = $request->input('list_check');
        if (!empty($list_check)) {
            $act = $request->input('act');
            if ($act == 'delete') {
                Page::destroy($list_check);
                return redirect('admin/page/list')->with('status_success', 'Bản ghi đã được đưa vào thừng rác =))');
            }

            if ($act == 'restore') {
                Page::withTrashed()
                    ->whereIn('page_id', $list_check)
                    ->restore();
                return redirect('admin/page/list')->with('status_success', 'Bạn đã khôi phục bản ghi thành công =))');
            }
            if ($act == 'forceDelete') {
                Page::withTrashed()
                    ->whereIn('page_id', $list_check)
                    ->forceDelete();
                return redirect('admin/page/list')->with('status_success', 'Bạn đã xóa bảng ghi thành công =))');
            }
        } else {
            return redirect('admin/page/list')->with('status_danger', 'Bạn chưa chọn đối trượng !!!');
        }

    }


    public function edit(Request $request, $page_id)
    {
            $page = Page::find($page_id);
            if ($page) {
                return view('admin.page.edit', compact('page'));
            } else {
                // Handle other statuses or not found
                abort(404, 'This page has been deleted!');
            }

    }
    public function update(Request $request, $page_id)
    {
        $request->validate(
            [
                'page_title' => 'required|string|max:100',
                'page_slug' => 'required|string|max:100',
                'page_content' => 'required|string',
                'page_status' => 'required|in:draft,published'
            ],
            [
                'required' => ':attribute không được để trống !',
                'min' => ':attribute Có độ dài ít nhất :min ký tự !',
                'max' => ':attribute Có độ dài tối đa :max ký tự !',
            ],
            [
                'page_title' => 'Tiêu đề trang',
                'page_slug' => 'Slug trang',
                'page_content' => 'Nội dung trang',
                'page_status' => 'Trạng thái'
            ]
        );

        Page::where('page_id', $page_id)->update(
            [
                'page_title' => $request->input('page_title'),
                'page_slug' => Slug::create_slug($request->input('page_slug')),
                'page_content' => $request->input('page_content'),
                'page_status' => $request->input('page_status'),
                'user_id' => auth()->user()->id,
            ]
        );
        return redirect('admin/page/list')->with('status_success', 'Bạn đã cập nhật trang thành công =))');
    }
}
