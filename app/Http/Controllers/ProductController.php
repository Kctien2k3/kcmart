<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product;
use App\Models\Image;
use App\Models\Product_category;
use App\Models\Product_image;
use App\Models\Slider;
use App\Models\Page;
use App\Models\Cart;
class ProductController extends Controller
{
    //
    public function show(Request $request, $category_slug)
    {
        //// get product_category list -> sidebar list
        $product_cats = Product_category::where([
            ['category_status', '=', 'published']
        ])->get();
        ////


        $category_id_by_slug = Product_category::where('category_slug', $category_slug)->pluck('category_id');
        foreach ($category_id_by_slug as $category_id) {
            //// lấy danh mục sản phẩm và truy xuất child 
            $category = Product_category::with('childs.childs')->find($category_id);
            // dd($category);  
            //// Lấy ID của danh mục hiện tại và tất cả danh mục con của nó
            $list_cats = collect([$category->category_id])
                ->merge($category->childs->pluck('category_id'))
                ->merge($category->childs->pluck('childs.*.category_id')->flatten())
                ->unique(); // Đảm bảo không có ID trùng lặp
            // dd($list_cats);
            //// Lấy tất cả sản phẩm thuộc các danh mục này
            $list_product_by_cat_id = Product::whereIn('category_id', $list_cats)->paginate(16);
            // dd($list_product_by_cat_id);
        }

        ///// get the all  products
        $all_products = Product::get();

        return view('client.product.show', compact('list_product_by_cat_id', 'product_cats', 'category_id', 'category', 'all_products'));
    }
    public function detail_product(Request $request, $product_slug)
    {
        $product_cats = Product_category::where([
            ['parent_id', 0],
            ['category_status', '=', 'published']
        ])->get();

        // dd($product_slug);
        $product_id_by_slug = Product::where('product_slug', $product_slug)->pluck('product_id');
        // dd($product_id_by_slug);
        foreach ($product_id_by_slug as $product_id) {

            $product_detail = Product::where('product_id', $product_id)->get();
            // dd($product_detail);     
            $product_images = Product_image::where('product_id', $product_id)->get();
            // dd($product_images);

            //// the same product
            foreach ($product_detail as $item) {
                $category_id = $item->category_id;
            }
        }
        $category = Product_category::with('childs.childs')->find($category_id);
        $list_cats = collect([$category->category_id])
            ->merge($category->childs->pluck('category_id'))
            ->merge($category->childs->pluck('childs.*.category_id')->flatten())
            ->unique(); // Đảm bảo không có ID trùng lặp
        $list_product_by_cat_id = Product::whereIn('category_id', $list_cats)->get();
        //    dd($list_product_by_cat_id);



        ///// get the all  products
        $all_products = Product::get();

        return view('client.product.detail', compact('product_detail', 'product_cats', 'list_product_by_cat_id', 'product_id', 'product_images', 'all_products'));
    }

}
