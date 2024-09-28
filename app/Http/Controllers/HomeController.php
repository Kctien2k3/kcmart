<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product;
use App\Models\Product_category;
use App\Models\Slider;
use App\Models\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth'); ///// yêu cầu đăng nhập
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    /////////////////////////////////////////////////////////////////////////// Home page
    public function index(Request $request)
    {
        //// get menu header 
        $menu_header = Page::where('page_status', 'published')->get();
        // dd($menu_header);
        //// get slider list
        $sliders = Slider::where('slider_status', 'published')->get();

        //// lấy danh mục sản phẩm và truy xuất child 
        $product_cats = Product_category::where([
            ['parent_id', 0],
            ['category_status', '=', 'published']
        ])->get();
        // dd($sub_cats);

        ///// get the all  products
        $all_products = Product::get();

        return view('client.home', compact('product_cats', 'sliders', 'menu_header', 'all_products'));
    }



    public function about(Request $request)
    {
        $menu_header = Page::where('page_status', 'published')->get();
        ///// get the all  products
        $all_products = Product::get();
        return view('client.about', compact('all_products', 'menu_header'));
    }
    public function contact(Request $request)
    {
        $menu_header = Page::where('page_status', 'published')->get();
        ///// get the all  products
        $all_products = Product::get();
        return view('client.contact', compact('all_products', 'menu_header'));
    }

    public function search(Request $request)
    {
        //// sidebar 
        $product_cats = Product_category::where([
            ['category_status', '=', 'published']
        ])->get();
        $all_products = Product::get();

        $keyword = "";
        if (!empty($request->input('keyword'))) {
            $keyword = $request->input('keyword');
        }else {
            return redirect('/');
        }
        $products = Product::where('Product_title', 'LIKE', "%{$keyword}%")->orderBy('updated_at', 'desc')->paginate(20);
        $count_searchResult = $products->count();
        return view('client.search', compact('products', 'product_cats', 'all_products', 'keyword', 'count_searchResult'));

    }
}
