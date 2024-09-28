<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Page;
use App\Models\Product;


class PostController extends Controller
{
    //
    public function post()
    {
        $menu_header = Page::where('page_status', 'published')->get();
        $list_post = Post::paginate(6);
        $all_products = Product::get();
        return view('client.post.show', compact('list_post', 'all_products', 'menu_header'));
    }
    public function post_detail(Request $request, $post_slug) {
        $post_detail = Post::where('post_slug', $post_slug)->get();
        $all_products = Product::get();
        return view('client.post.detail', compact('post_detail', 'all_products'));
    }
}
