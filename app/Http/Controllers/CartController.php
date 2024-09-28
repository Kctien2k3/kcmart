<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Product_image;
use App\Models\Cart;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;


class CartController extends Controller
{
    //  
    public function index(Cart $cart)
    {
        return view('client.cart.show');
    }

    public function add_cart(Request $request, $product_id, Cart $cart)
    {

        if ($request->has('buy_now')) {
            // $product_id = $request->input('product_id');

            $quantity = $request->input('quantity');
            // dd($quantity);
            $product_info = Product::find($product_id);
            $cart->add($product_info, $quantity); // thực hiện lưu thông tin của sản phẩm vào giỏ hàng
            return redirect()->route('cart')->with('Msg_success', 'Sản phẩm đã được thêm vào giỏ hàng!');
        } else {
            // $product_id = $request->input('product_id');
            $quantity = $request->input('quantity');
            // dd($quantity);
            $product_info = Product::find($product_id);
            $cart->add($product_info, $quantity); // thực hiện lưu thông tin của sản phẩm vào giỏ hàng
            return back()->with('Msg_success', 'Sản phẩm đã được thêm vào giỏ hàng!');
        }


    }

    public function delete_cart($product_id, Cart $cart)
    {
        // dd($product_id);
        $cart->remove($product_id);
        return redirect()->route('cart');

    }

    public function update_cart(Request $request, Cart $cart)
    {
        $quantity = $request->input('quantity');
        $product_id = $request->input('product_id');
        // dd($quantity);
        $cart->updateCart($product_id, $quantity);  /// 2 dữ liệu cần quan tâm là id và số lượng sản phẩm
        // dd($cart);
        return redirect()->route('cart');
    }
    public function clear_cart(Cart $cart)
    {
        $cart->clear();
        return redirect()->route('cart');
    }
}
