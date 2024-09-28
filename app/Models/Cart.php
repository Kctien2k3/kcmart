<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product_image;
use App\Models\Image;

class Cart extends Model
{
    use HasFactory;
    /////////////// khai báo biến lưu trữ 
    public $carts = []; /// đây là biên lưu thông tin sản phẩm được add vào 
    public $totalPrice = 0; /// đây là biến khai báo tính tổng giá trong giỏ hàng 
    public $totalQuantity = 0; /// đây là biến giúp tính tổng số lượng sản phẩm trong giỏ hàng
    public function __construct()
    {
        $this->carts = session('cart') ? session('cart') : []; /// thực hiện lưu giữ sản phẩm đã thêm nếu thêm một sp mới về sau
        $this->totalPrice = $this->get_totalPrice();
        $this->totalQuantity = $this->get_totalQuantity();
    }
    ///////// hàm lưu trữ sản phẩm thông qua phương thức session 
    public function add($product_info, $quantity)
    {
        if (isset($this->carts[$product_info->product_id])) {
            if (empty($quantity)) {
                $this->carts[$product_info->product_id]->product_quantity += 1; /// thực hiện cập nhật số lượng sản phẩm được thêm vào
            }else {
                $this->carts[$product_info->product_id]->product_quantity += $quantity; /// thực hiện cập nhật số lượng sản phẩm được thêm vào
            }
        } else {
            $cart_items = (object) [
                'product_id' => $product_info->product_id,
                'product_slug' => $product_info->product_slug,
                'product_title' => $product_info->product_title,
                'product_image' => $product_info->image->image_url,
                'product_price' => $product_info->sale_price ? $product_info->sale_price : $product_info->product_price,
                'product_quantity' => $quantity ? $quantity : 1,
                'is_featured' => $product_info->is_featured,
            ];
            // dd($cart_items);
            $this->carts[$product_info->product_id] = $cart_items; /// thực hiện lưu thông tin get được vào biến carts

        }

        session(['cart' => $this->carts]); /// lưu vào cart với session
        // dd($this->carts);

    }

    public function remove($product_id)
    {
        if (isset($this->carts[$product_id])) {
            unset($this->carts[$product_id]);
            session(['cart' => $this->carts]); /// lưu cập nhật session sau khi xóa
        }
    }

    public function updateCart($product_id, $quantity)
    {
        if (isset($this->carts[$product_id])) {
            $this->carts[$product_id]->product_quantity = $quantity; // cập nhật bằng với số lượng chỉnh sửa là biến $quantity
        }
        // return json_encode([
        //     'totalPrice' => $this->totalPrice,
        //     'totalQuantity' => $this->totalQuantity
        // ]);
    }

    public function clear()
    {
        session(['cart' => null]);
    }




    ////toán tử tính tổng
    private function get_totalPrice()
    {
        $total = 0;
        foreach ($this->carts as $item) {
            $total += $item->product_quantity * $item->product_price;
        }
        return $total;
    }
    private function get_totalQuantity()
    {
        $total = 0;
        foreach ($this->carts as $item) {
            $total += $item->product_quantity;
        }
        return $total;
    }
 
}
