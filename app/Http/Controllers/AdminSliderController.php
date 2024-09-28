<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\Image;
use App\Models\Slug;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AdminSliderController extends Controller
{
    //active menu
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'slider']);
            return $next($request);
        });
    }
    ////////////////////////////////////////////////////////////
    function list(Request $request)
    {
        $sliders = Slider::orderBy('updated_at', 'desc')->paginate(7);
        $count_slider_all = Slider::count();
        $count_slider_published = Slider::where('slider_status', '=', 'published')->count();
        $count_slider_draft = Slider::where('slider_status', '=', 'draft')->count();
        $count = [$count_slider_all, $count_slider_published, $count_slider_draft];
        return view('admin.slider.list', compact('sliders', 'count'));
    }

    function add(Request $request)
    {
        return view('admin.slider.add');
    }
    function store(Request $request)
    {
        //// validation 
        $request->validate(
            [
                'slider_title' => 'required|string|max:100',
                'slider_url' => 'required|string|max:100',
                'slider_desc' => 'required|string',
                'slider_status' => 'required|in:draft,published',
                'image' => 'required|nullable|mimes:png,jpg,jpeg,webp|max:1024'
            ],
            [
                'required' => ':attribute Không được để trống !',
                'min' => ':attribute Có độ dài ít nhất :min ký tự !',
                'max' => ':attribute Có độ dài tối đa :max ký tự !',
                'image.max' => `Hình ảnh có dung lượng tối đa :max KB !`,
            ],
            [
                'slider_title' => 'Tên slider',
                'slider_url' => 'Link slider',
                'slider_desc' => 'Nội dung slider',
                'slider_status' => 'Trạng thái',
                'image' => 'File/hình ảnh',
            ]
        );

        // dd($request->hasFile('image'));
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $path = 'public/uploads/slider/';
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


        Slider::create(
            [
                'slider_title' => $request->input('slider_title'),
                'slider_url' => Slug::create_slug($request->input('slider_url')),
                'slider_desc' => $request->input('slider_desc'),
                'slider_status' => $request->input('slider_status'),
                'user_id' => auth()->user()->id,
                'image_id' => $image_id
            ]
        );

        return redirect('admin/slider/list')->with('status_success', 'Bạn đã thêm slider thành công =))');
    }

    public function edit(Request $request, int $slider_id)
    {
        // Find the slider and image by their respective IDs
        $slider = Slider::findOrFail($slider_id);
        return view('admin.slider.edit', compact('slider'));
    }

    function update(Request $request, $slider_id)
    {
        $request->validate(
            [
                'slider_title' => 'required|string|max:100',
                'slider_url' => 'required|string|max:100',
                'slider_desc' => 'required|string',
                'slider_status' => 'required|in:draft,published',
                'image' => 'nullable|mimes:png,jpg,jpeg,webp|max:1024',
            ],
            [
                'required' => ':attribute Không được để trống !!!',
                'min' => ':attribute Có độ dài ít nhất :min ký tự !!!',
                'max' => ':attribute Có độ dài tối đa :max ký tự !!!',
                'image.max' => `Hình ảnh có dung lượng tối đa :max KB !`,
            ],
            [
                'slider_title' => 'Tên slider',
                'slider_url' => 'Link slider',
                'slider_desc' => 'Nội dung slider',
                'slider_status' => 'Trạng thái',
                'image' => 'File/hình ảnh',

            ]
        );
        $slider = Slider::findOrFail($slider_id);
        //    dd($request->hasFile('image'));
        // Cập nhật ảnh mới nếu có
        if ($request->hasFile('image')) {
            // xóa file hình cũ     
            $image = Image::where('image_id', $slider->image_id)->first();
            // dd($image);
            if (!empty($image)) {
                File::delete('public/uploads/slider/' . $image->file_name);
            }
            // upload ảnh mới 
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $path = 'public/uploads/slider/';
            // Get file information
            $filesize = $file->getSize();
            $file->move($path, $filename);

            Image::where('image_id', $slider->image_id)->update([
                'image_url' => $path . $filename,
                'file_name' => $filename,
                'file_size' => $filesize,
                'user_id' => auth()->user()->id,

            ]);
        }
        // Cập nhật thông tin slider
        Slider::where('slider_id', $slider_id)->update([
            'slider_title' => $request->input('slider_title'),
            'slider_url' => Slug::create_slug($request->input('slider_url')),
            'slider_desc' => $request->input('slider_desc'),
            'slider_status' => $request->input('slider_status'),
            'user_id' => auth()->user()->id,
        ]);

        return redirect('admin/slider/list')->with('status_success', 'Bạn đã cập nhật slider thành công =))');
    }

    function delete(Request $request, $slider_id, $image_id)
    {
        // Tìm Slider và Image theo ID
        $slider = Slider::find($slider_id);
        $image = Image::find($image_id);

        if (!empty($image)) {
            File::delete('public/uploads/slider/' . $image->file_name);
        }

        // Xóa bản ghi Slider và Image
        if ($slider) {
            $slider->delete();
        }

        if ($image) {
            $image->delete();
        }

        // Chuyển hướng và thông báo thành công
        return redirect('admin/slider/list')->with('status_success', 'Bản ghi đã được xóa thành công =))');
    }
}
