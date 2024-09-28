<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Image;
use App\Models\Slug;
// use App\Models\Slider;
use App\Models\Post_category;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;


class AdminPostController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'post']);
            return $next($request);
        });
    }
    public function list(Request $request)
    {
        $status = $request->input('status');
        $list_act = [
            'delete' => 'xóa tạm thời'
        ];

        if ($status == 'trash') {
            $list_act = [
                'restore' => 'khôi phục',
                'forceDelete' => 'xóa vĩnh viễn'
            ];
            $posts = Post::onlyTrashed()->orderBy('updated_at', 'desc')->paginate(10);
        } elseif ($status == 'published') {
            $posts = Post::where('post_status', '=', 'published')->orderBy('updated_at', 'desc')->paginate(10);
        } elseif ($status == 'draft') {
            $posts = Post::where('post_status', '=', 'draft')->orderBy('updated_at', 'desc')->paginate(10);
        } else {
            $keyword = "";
            if ($request->input("keyword")) {
                $keyword = $request->input('keyword');
            }
            $posts = Post::where('post_title', 'LIKE', "%{$keyword}%")->orderBy('updated_at', 'desc')->paginate(10);
        }
        $count_post_all = Post::count();
        $count_post_published = Post::where('post_status', '=', 'published')->count();
        $count_post_draft = Post::where('post_status', '=', 'draft')->count();
        $count_post_trash = Post::onlyTrashed()->count();

        $count = [$count_post_all, $count_post_published, $count_post_draft, $count_post_trash];
        return view('admin.post.list', compact('posts', 'count', 'list_act'));
    }

    public function add(Request $request)
    {
        $categories = Post_category::orderBy('category_name', 'ASC')
            ->with('childs')
            ->get();
        $categories = Post_category::ShowCategories($categories);
        return view('admin.post.add', compact('categories'));
    }
    public function store(Request $request)
    {
        $request->validate(
            [
                'post_title' => 'required|string|max:255',
                'post_slug' => 'required|string|max:255',
                'post_content' => 'required|string',
                'post_status' => 'required|in:draft,published',
                'category_id' => 'required',
                'image' => 'required|nullable|mimes:png,jpg,jpeg|max:1024'
            ],
            [
                'required' => ':attribute Không được để trống !',
                'min' => ':attribute Có độ dài ít nhất :min ký tự !',
                'max' => ':attribute Có độ dài tối đa :max ký tự !',
                'image.max' => `Hình ảnh có dung lượng tối đa :max KB !`,
            ],
            [
                'post_title' => 'Tiêu đề Bài viết',
                'post_slug' => 'Slug bài viết',
                'post_content' => 'Nội dung bài viết',
                'post_status' => 'Trạng thái',
                'category_id' => 'Danh mục bài viết',
                'image' => 'File/Hình ảnh'
            ]
        );

        // dd($request->hasFile('image'));
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $path = 'public/uploads/post/';
            // Get file information
            $filesize = $file->getSize();
            $file->move($path, $filename);

            $image = Image::create([
                'image_url' => $path . $filename,
                'file_name' => $filename,
                'file_size' => $filesize,
                'user_id' => auth()->user()->id,

            ]);
            $image_id = $image->image_id;
        }


        Post::create(
            [
                'post_title' => $request->input('post_title'),
                'post_slug' => Slug::create_slug($request->input('post_slug')),
                'post_content' => $request->input('post_content'),
                'post_status' => $request->input('post_status'),
                'post_excerpt' => $request->input('post_excerpt'),
                'user_id' => auth()->user()->id,
                'category_id' => $request->input('category_id'),
                'image_id' => $image_id,
            ]
        );
        return redirect('admin/post/list')->with('status_success', 'Bạn đã thêm bài viết thành công =))');
    }

    public function action(Request $request)
    {
        $list_check = $request->input('list_check');
        // dd($list_check);
        if (!empty($list_check)) {
            $act = $request->input('act');
            if ($act == 'delete') {
                Post::destroy($list_check);
                return redirect('admin/post/list')->with('status_success', 'Bản ghi đã được đưa vào thùng rác =))');
            }
            if ($act == 'restore') {
                Post::withTrashed()
                    ->whereIn('post_id', $list_check)
                    ->restore();
                return redirect('admin/post/list')->with('status_success', 'Bản ghi đã được khôi phục thành công =))');
            }
            if ($act == 'forceDelete') {
                Post::withTrashed()->whereIn('post_id', $list_check)->forceDelete();             
                $posts = Post::withTrashed()->whereIn('post_id', $list_check)->pluck('image_id');
                $images = Image::whereIn('image_id', $posts)->get();
                foreach ($images as $image) {
                    File::delete('public/uploads/post/' . $image->file_name);
                    $image->delete();
                }
                return redirect('admin/post/list')->with('status_success', 'Bản ghi đã được xóa vĩnh viễn =))');
            }
            if (empty($list_act)) {
                return redirect('admin/post/list')->with('status_danger', 'Bạn chưa chọn tác vụ !!! =))');
            }
        } else {
            return redirect('admin/post/list')->with('status_danger', 'Bạn chưa chọn đối tượng nào !!!');
        }

    }
    public function edit($post_id)
    {
        $post = Post::find($post_id);
        // dd($post);
        if ($post) {
            $post_cats = Post_category::orderBy('category_name', 'ASC')
                ->with('childs')
                ->get();
            $ShowCategories = Post_category::ShowCategories($post_cats);
            return view('admin.post.edit', compact('post', 'ShowCategories'));
        } else {
            abort(404, 'This page has been deleted!');
        }
    }
    public function update(Request $request, $post_id)
    {
        $request->validate(
            [
                'post_title' => 'required|string|max:255',
                'post_slug' => 'required|string|max:255',
                'post_content' => 'required|string',
                'post_status' => 'required|in:draft,published',
                'category_id' => 'required',
                'image' => 'required|nullable|mimes:png,jpg,jpeg|max:1024'
            ],
            [
                'required' => ':attribute không được để trống !',
                'min' => ':attribute Có độ dài ít nhất :min ký tự !',
                'max' => ':attribute Có độ dài tối đa :max ký tự !',
                'image.max' => `Hình ảnh có dung lượng tối đa :max KB !`,
            ],
            [
                'post_title' => 'Tiêu đề Bài viết',
                'post_slug' => 'Slug bài viết',
                'post_content' => 'Nội dung bài viết',
                'post_status' => 'Trạng thái',
                'category_id' => 'Danh mục bài viết',
                'image' => 'File/Hình ảnh'
            ]
        );

        $post = Post::findOrFail($post_id);
        //    dd($request->hasFile('image'));
        // Cập nhật ảnh mới nếu có
        if ($request->hasFile('image')) {
            // xóa file hình cũ     
            $image = Image::where('image_id', $post->image_id)->first();
            // dd($image); 
            if (!empty($image)) {
                File::delete('public/uploads/post/' . $image->file_name);
            }
            // upload ảnh mới 
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $path = 'public/uploads/post/';
            // Get file information
            $filesize = $file->getSize();
            $file->move($path, $filename);

            Image::where('image_id', $post->image_id)->update([
                'image_url' => $path . $filename,
                'file_name' => $filename,
                'file_size' => $filesize,
                'user_id' => auth()->user()->id,
            ]);
        }

        Post::where('post_id', $post_id)->update(
            [
                'post_title' => $request->input('post_title'),
                'post_slug' => Slug::create_slug($request->input('post_slug')),
                'post_content' => $request->input('post_content'),
                'post_status' => $request->input('post_status'),
                'post_excerpt' => $request->input('post_excerpt'),
                'user_id' => auth()->user()->id,
                'category_id' => $request->input('category_id'),
            ]
        );
        return redirect('admin/post/list')->with('status_success', 'Bạn đã cập nhật bài viết thành công =))');
    }

    public function delete(Request $request, $post_id)
    {
        $status = $request->input('status');
        if ($status != 'trash') {
            $post = Post::find($post_id);
            if ($post) {
                $post->delete();
                return redirect('admin/post/list')->with('status_success', 'Bản ghi đã được đưa vào thùng rác =))');
            } else {
                $post = Post::onlyTrashed()->find($post_id);
                if ($post->image) {
                    File::delete('public/uploads/post/' . $post->image->file_name);
                    $post->image->delete();

                } 
                $post->forceDelete();
                return redirect('admin/post/list')->with('status_success', 'Bạn đã xóa bảng ghi thành công =))');
            }
        }
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////// category edit 
    public function list_cat(Request $request)
    {

        $post_cat = Post_category::with('user')->orderBy('category_name', 'ASC')
            ->with('childs')
            ->get();

        // dump($categories);
        $selected_category_id = $request->input('parent_id');
        $ShowCategories = Post_category::ShowCategories($post_cat);
        // dd($category1);
        $TableCategories = Post_category::TableCategories($post_cat);
        return view('admin.post.list_cat', compact('post_cat', 'ShowCategories', 'TableCategories'));

    }


    public function add_cat(Request $request)
    {
        $request->validate(
            [
                'category_name' => 'required|string|max:100',
                'category_slug' => 'required|string|max:100',
                'category_desc' => 'string|max:255',
                'category_status' => 'required|in:draft,published'
            ],
            [
                'required' => ':attribute không được để trống !!!',
                'min' => ':attribute Có độ dài ít nhất :min ký tự !!!',
                'max' => ':attribute Có độ dài tối đa :max ký tự !!!',
            ],
            [
                'category_name' => 'Tên danh mục',
                'category_slug' => 'Slug danh mục',
                'category_desc' => 'Mô tả danh mục',
                'category_status' => 'Trạng thái',
                'parent_id' => 'Danh mục cha',
                'user_id' => 'Người tạo',

            ]
        );

        Post_category::create(
            [
                'category_name' => $request->input('category_name'),
                'category_slug' => Slug::create_slug($request->input('category_slug')),
                'category_desc' => $request->input('category_desc'),
                'category_status' => $request->input('category_status'),
                'parent_id' => $request->input('parent_id'),
                'user_id' => Auth::user()->id,
            ]
        );
        return redirect('admin/post/cat/list_cat')->with('status_success', 'Bạn đã thêm danh mục thành công =))');
    }

    public function delete_cat(Request $request, $category_id)
    {
        $post_cat = Post_category::find($category_id);
        $post_cat->delete();
        return redirect('admin/post/cat/list_cat')->with('status_success', 'Đã xóa bản ghi thành công =))');

    }

    public function edit_cat(Request $request, $category_id)
    {
        $post_cats = Post_category::orderBy('category_name', 'ASC')
            ->with('childs')
            ->get();
        $post_cat = Post_category::find($category_id);
        $ShowCategories = Post_category::find($category_id)->ShowCategories($post_cats);
        $TableCategories = Post_category::find($category_id)->TableCategories($post_cats);
        return view('admin.post.edit_cat', compact('post_cats', 'post_cat', 'ShowCategories', 'TableCategories'));
    }

    function update_cat(Request $request, $category_id)
    {
        $request->validate(
            [
                'category_name' => 'required|string|max:100',
                'category_slug' => 'required|string|max:100',
                'category_desc' => 'string|max:255',
                'category_status' => 'required|in:draft,published',
                'parent_id' => 'required|unique:categories,category_id',
            ],
            [
                'required' => ':attribute không được để trống !!!',
                'min' => ':attribute Có độ dài ít nhất :min ký tự !!!',
                'max' => ':attribute Có độ dài tối đa :max ký tự !!!',
                'unique' => ':attribute đã tồn tại, vui lòng chọn mục khác !!!',
            ],
            [
                'category_name' => 'Tên danh mục',
                'category_slug' => 'Slug trang',
                'category_desc' => 'Mô tả danh mục',
                'category_status' => 'Trạng thái',
                'parent_id' => 'Danh mục cha',
                'user_id' => 'Người tạo',
            ]
        );

        Post_category::where('category_id', $category_id)->update(
            [
                'category_name' => $request->input('category_name'),
                'category_slug' => Slug::create_slug($request->input('category_slug')),
                'category_desc' => $request->input('category_desc'),
                'category_status' => $request->input('category_status'),
                'parent_id' => $request->input('parent_id'),
                'user_id' => Auth::user()->id,
            ]
        );
        return redirect('admin/post/cat/list_cat')->with('status_success', 'Bạn đã cập nhật danh mục thành công =))');
    }
}
