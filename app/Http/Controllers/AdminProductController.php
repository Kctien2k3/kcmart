<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product;
use App\Models\Image;
use App\Models\Slug;
use App\Models\Product_category;
use App\Models\Product_image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class AdminProductController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'product']);
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
            $products = Product::onlyTrashed()->orderBy('updated_at', 'desc')->paginate(10);
        } elseif ($status == 'actived') {
            $products = Product::where('product_status', '=', 'active')->orderBy('updated_at', 'desc')->paginate(10);
        } elseif ($status == 'inactived') {
            $products = Product::where('product_status', '=', 'inactive')->orderBy('updated_at', 'desc')->paginate(10);
        } else {
            $keyword = "";
            if ($request->input('keyword')) {
                $keyword = $request->input('keyword');
            }
            $products = Product::where('product_title', 'LIKE', "%{$keyword}%")->orderBy('updated_at', 'desc')->paginate(10);

        }
        ;
        // 
        $count_product_active = Product::count();
        $count_product_trash = Product::onlyTrashed()->count();
        $count_product_actived = Product::where('product_status', '=', 'active')->count();
        $count_product_inactived = Product::where('product_status', '=', 'inactive')->count();
        $count = [$count_product_active, $count_product_trash, $count_product_actived, $count_product_inactived];


        return view('admin.product.list', compact('products', 'count', 'list_act'));
    }

    public function add(Request $request)
    {
        $categories = Product_category::orderBy('category_name', 'ASC')
            ->with('childs')
            ->get();
        $ShowCategories = Product_category::ShowCategories($categories);
        return view('admin.product.add', compact('categories', 'ShowCategories'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'product_title' => 'required|string|max:255',
                // 'product_code' => 'required|string|max:200',
                'product_slug' => 'required|string|max:255',
                'product_desc' => 'required|string|min:5',
                'product_price' => 'required|min:0',
                'product_status' => 'required|in:active,inactive',
                'category_id' => 'required',
                'stock_quantity' => 'required|integer|min:0',
                'product_details' => 'nullable|string',
                'image' => 'required|mimes:png,jpg,jpeg,webp|max:1024',
                'gallery' => 'required',
            ],
            [
                'required' => ':attribute Không được để trống !',
                'min' => ':attribute Có độ dài ít nhất :min ký tự !',
                'max' => ':attribute Có độ dài tối đa :max ký tự !',
                'numeric' => ':attribute phải là một số !',
                'integer' => ':attribute phải là một số nguyên !',
                'in' => ':attribute phải là một trong các giá trị: :values',
                'image.max' => `Hình ảnh có dung lượng tối đa :max KB !`,
            ],
            [
                'product_title' => 'Tên sản phẩm',
                'product_slug' => 'Slug sản phẩm',
                'product_desc' => 'Mô tả sản phẩm',
                'product_status' => 'Trạng thái',
                'product_price' => 'Giá sản phẩm',
                'stock_quantity' => 'Số lượng sản phẩm',
                'product_details' => 'Chi tiết sản phẩm',
                'is_featured' => 'Sản phẩm nổi bật',
                'category_id' => 'Danh mục',
                'image' => 'File/Hình ảnh',
                'gallery' => 'File/Hình ảnh'
            ]
        );
        $products = Product::create([
            'product_title' => $request->input('product_title'),
            // 'product_code' =>'PRO#' . Str::upper(Str::random(3)) . mt_rand(100, 999),
            'product_slug' => Slug::create_slug($request->input('product_slug')),
            'product_price' => $request->input('product_price'),
            'product_oldPrice' => $request->input('product_oldPrice') ?? '',
            'stock_quantity' => $request->input('stock_quantity'),
            'product_desc' => $request->input('product_desc'),
            'product_details' => $request->input('product_details'),
            'product_status' => $request->input('product_status'),
            'is_featured' => $request->input('is_featured') ?? 0,
            'category_id' => $request->input('category_id'),
            'user_id' => auth()->user()->id,
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $path = 'public/uploads/product/';
            $filesize = $file->getSize();
            $file->move($path, $filename);

            $image = Image::create([
                'image_url' => $path . $filename,
                'file_name' => $filename,
                'file_size' => $filesize,
                'user_id' => auth()->user()->id,
            ]);
            $image_id = $image->image_id;
            $product_id = $products->product_id;
            if ($image_id) {
                Product_image::create([
                    'image_id' => $image_id,
                    'product_id' => $product_id,
                    'pin' => '1'
                ]);
            }
            ;
        }
        if ($request->hasFile('gallery')) {
            $files = $request->file('gallery');
            foreach ($files as $key => $file) {
                $extension = $file->getClientOriginalExtension();
                $filename = $key . '-' . time() . '.' . $extension;
                $path = 'public/uploads/product/gallery/';
                $filesize = $file->getSize();
                $file->move($path, $filename);

                $image = Image::create([
                    'image_url' => $path . $filename,
                    'file_name' => $filename,
                    'file_size' => $filesize,
                    'user_id' => auth()->user()->id,
                ]);
                $image_id = $image->image_id;
                $product_id = $products->product_id;
                if ($image_id) {
                    Product_image::create([
                        'image_id' => $image_id,
                        'product_id' => $product_id,
                        'pin' => '0',
                    ]);
                }
            }

        }
        return redirect('admin/product/list')->with('status_success', 'Bạn đã thêm sản phẩm thành công =))');
    }

    public function action(Request $request)
    {
        $list_check = $request->input('list_check');
        // dd($list_check);
        if (!empty($list_check)) {
            $act = $request->input('act');
            if ($act == 'delete') {
                Product::destroy($list_check);
                return redirect('admin/product/list')->with('status_success', 'Bản ghi đã được đưa vào thùng rác =))');
            }
            if ($act == 'restore') {
                Product::withTrashed()
                    ->whereIn('product_id', $list_check)
                    ->restore();
                return redirect('admin/product/list')->with('status_success', 'Bản ghi đã khôi phục thành công =))');
            }
            if ($act == 'forceDelete') {
                Product::withTrashed()->whereIn('product_id', $list_check)->forceDelete();
                $product_image_id = Product_image::whereIn('product_id', $list_check)->pluck('image_id');
                $images = Image::whereIn('image_id', $product_image_id)->get();
                // dd($images);
                foreach ($images as $image) {
                    File::delete('public/uploads/product/' . $image->file_name);
                    File::delete('public/uploads/product/gallery/' . $image->file_name);
                    $image->delete();
                }
                return redirect('admin/product/list')->with('status_success', 'Bản ghi đã xóa thành công =))');
            }
            if (empty($list_act)) {
                return redirect('admin/product/list')->with('status_danger', 'Bạn chưa chọn tác vụ !!!');
            }
        } else {
            return redirect('admin/product/list')->with('status_danger', 'Bạn chưa chọn đối tượng !!!');
        }
    }

    public function edit(Request $request, $product_id)
    {
        $categories = Product_category::orderBy('category_name', 'ASC')
            ->with('childs')
            ->get();
        $ShowCategories = Product_category::ShowCategories($categories);
        $product_images = Product_image::where('product_id', $product_id)->get();
        $product = Product::find($product_id);
        return view('admin.product.edit', compact('product', 'ShowCategories', 'product_images'));
    }

    public function update(Request $request, $product_id)
    {
        $request->validate(
            [
                'product_title' => 'required|string|max:255',
                'product_slug' => 'required|string|max:255',
                'product_desc' => 'required|min:5',
                'product_price' => 'required|min:0',
                'product_status' => 'required|in:active,inactive',
                'category_id' => 'required',
                'stock_quantity' => 'required|integer|min:0',
                'product_details' => 'nullable|string',
                'image' => 'mimes:png,jpg,jpeg,webp|max:1024',
                // 'gallery' => 'required',
            ],
            [
                'required' => ':attribute Không được để trống !',
                'min' => ':attribute Có độ dài ít nhất :min ký tự !',
                'max' => ':attribute Có độ dài tối đa :max ký tự !',
                'numeric' => ':attribute phải là một số !',
                'integer' => ':attribute phải là một số nguyên !',
                'in' => ':attribute phải là một trong các giá trị: :values',
                'image.max' => `Hình ảnh có dung lượng tối đa :max KB !`,
            ],
            [
                'product_title' => 'Tên sản phẩm',
                'product_slug' => 'Slug sản phẩm',
                'product_desc' => 'Mô tả sản phẩm',
                'product_status' => 'Trạng thái',
                'product_price' => 'Giá sản phẩm',
                'stock_quantity' => 'Số lượng sản phẩm',
                'product_details' => 'Chi tiết sản phẩm',
                'is_featured' => 'Sản phẩm nổi bật',
                'category_id' => 'Danh mục',
                'image' => 'File/Hình ảnh',
                'gallery' => 'File/Hình ảnh'

            ]


        );
        Product::where('product_id', $product_id)->update([

            'product_title' => $request->input('product_title'),
            'product_slug' => Slug::create_slug($request->input('product_slug')),
            'product_price' => $request->input('product_price'),
            'product_oldPrice' => $request->input('product_oldPrice') ?? '',
            'stock_quantity' => $request->input('stock_quantity'),
            'product_desc' => $request->input('product_desc'),
            'product_details' => $request->input('product_details'),
            'product_status' => $request->input('product_status'),
            'is_featured' => $request->input('is_featured') ?? 0,
            'category_id' => $request->input('category_id'),
            'user_id' => auth()->user()->id,
        ]);
        $check_delete = $request->delete_oldImage;
        $product = Product::findOrFail($product_id);
        //    dd($request->hasFile('image'));
        if ($request->hasFile('image')) {
            $image = Image::where('image_id', $product->image->image_id)->first();
            // dd($image);
            if (!empty($image)) {
                File::delete('public/uploads/product/' . $image->file_name);
            }
            // upload ảnh mới 
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $path = 'public/uploads/product/';
            $filesize = $file->getSize();
            $file->move($path, $filename);

            $image = Image::where('image_id', $product->image->image_id)->update([
                'image_url' => $path . $filename,
                'file_name' => $filename,
                'file_size' => $filesize,
                'user_id' => auth()->user()->id,
            ]);
        }
        if ($request->hasFile('gallery')) {
            // xóa file hình cũ
            $list_image_id = Product_image::where([
                ['pin', '0'],
                ['product_id', $product->product_id]
            ])->pluck('image_id')->toArray();
            // dd($image_id);
            $images = Image::whereIn('image_id', $list_image_id)->get();
            // dd($image);
            if (!empty($images)) {
                foreach ($images as $image) {
                    if ($check_delete == 'yes') {
                        File::delete('public/uploads/product/gallery/' . $image->file_name);
                        $image->delete();
                    }
                }
            }
            // upload ảnh mới 
            $files = $request->file('gallery');
            foreach ($files as $key => $file) {
                $extension = $file->getClientOriginalExtension();
                $filename = $key . '-' . time() . '.' . $extension;
                $path = 'public/uploads/product/gallery/';
                $filesize = $file->getSize();
                $file->move($path, $filename);

                $image = Image::create([
                    'image_url' => $path . $filename,
                    'file_name' => $filename,
                    'file_size' => $filesize,
                    'user_id' => auth()->user()->id,
                ]);
                $image_id = $image->image_id;
                $product_id = $product->product_id;
                if ($image_id) {
                    Product_image::create([
                        'image_id' => $image_id,
                        'product_id' => $product_id,
                        'pin' => '0',
                    ]);
                }
            }

        }
        return redirect('admin/product/list')->with('status_success', 'Đã cập nhật thành công =))');
    }

    public function delete(Request $request, $product_id)
    {
        $status = $request->input('status');
        if ($status != 'trash') {
            $product = Product::find($product_id);
            if ($product) {
                $product->delete();
                return redirect('admin/product/list')->with('status_success', 'Bản ghi đã được đưa vào thùng rác =))');
            } else {
                $product = Product::onlyTrashed()->find($product_id);
                $product_image_id = Product_image::where('product_id', $product_id)->pluck('image_id');
                $images = Image::whereIn('image_id', $product_image_id)->get();
                // dd($images);
                foreach ($images as $image) {
                    File::delete('public/uploads/product/' . $image->file_name);
                    File::delete('public/uploads/product/gallery/' . $image->file_name);
                    $image->delete();
                }
                $product->forceDelete();
                return redirect('admin/product/list')->with('status_success', 'Bạn đã xóa bảng ghi thành công =))');
            }
        }
    }

    /////////////////////////////////////////////////////////////////////////////////////////// product_category
    public function list_cat(Request $request)
    {
        $categories = Product_category::orderBy('category_name', 'ASC')
            ->get();
        $ShowCategories = Product_category::ShowCategories($categories);
        return view('admin.product.list_cat', compact('categories', 'ShowCategories'));
    }

    public function add_cat(Request $request)
    {
        $request->validate(
            [
                'category_name' => 'required|string|max:255',
                'category_slug' => 'required|string|max:255',
                'category_desc' => 'string',
                'category_status' => 'required|in:draft,published'
            ],
            [
                'required' => ':attribute Không được để trống !',
                'min' => ':attribute Có độ dài ít nhất :min ký tự !',
                'max' => ':attribute Có độ dài tối đa :max ký tự !',
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

        Product_category::create(
            [
                'category_name' => $request->input('category_name'),
                'category_slug' => Slug::create_slug($request->input('category_slug')),
                'category_desc' => $request->input('category_desc') ?? '',
                'category_status' => $request->input('category_status'),
                'parent_id' => $request->input('parent_id'),
                'user_id' => Auth::user()->id,
            ]
        );
        return redirect('admin/product/cat/list_cat')->with('status_success', 'Bạn đã thêm danh mục thành công =))');
    }

    public function delete_cat(Request $request, $category_id)
    {
        $cat = Product_category::find($category_id);
        $cat->delete();
        return redirect('admin/product/cat/list_cat')->with('status_success', 'Đã xóa bản ghi thành công =))');
    }

    public function edit_cat(Request $request, $category_id)
    {
        $categories = Product_category::orderBy('category_name', 'ASC')
            ->with('childs')
            ->get();
        $category = Product_category::find($category_id);
        $TableCategories = Product_category::TableCategories($categories);

        return view('admin.product.edit_cat', compact('categories', 'category', 'TableCategories'));
    }

    function update_cat(Request $request, $category_id)
    {
        $request->validate(
            [
                'category_name' => 'required|string|max:255',
                'category_slug' => 'required|string|max:255',
                // 'category_desc' => 'string',
                'category_status' => 'required|in:draft,published'
            ],
            [
                'required' => ':attribute Không được để trống !!!',
                'min' => ':attribute Có độ dài ít nhất :min ký tự !!!',
                'max' => ':attribute Có độ dài tối đa :max ký tự !!!',
            ],
            [
                'category_name' => 'Tên danh mục',
                'category_slug' => 'Slug trang',
                // 'category_desc' => 'Mô tả danh mục',
                'category_status' => 'Trạng thái',
                'parent_id' => 'Danh mục cha',
                'user_id' => 'Người tạo',

            ]
        );

        Product_category::where('category_id', $category_id)->update(
            [
                'category_name' => $request->input('category_name'),
                'category_slug' => Slug::create_slug($request->input('category_slug')),
                // 'category_desc' => $request->input('category_desc'),
                'category_status' => $request->input('category_status'),
                'parent_id' => $request->input('parent_id'),
                'user_id' => Auth::user()->id,
            ]
        );
        return redirect('admin/product/cat/list_cat')->with('status_success', 'Bạn đã cập nhật danh mục thành công =))');
    }
}



