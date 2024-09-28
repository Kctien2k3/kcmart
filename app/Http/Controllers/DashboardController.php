<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;


class DashboardController extends Controller
{
    //
    public function __construct() {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'dashboard']);
            return $next($request);
        });
    }   
    public function show(Request $request) {
        $new_orders = Order::orderBy('updated_at', 'desc')->paginate(10);

        $count_order_all = Order::count();
        $count_order_pending = Order::where('status', '=', "pending")->count();
        $count_order_processing = Order::where('status', '=', "processing")->count();
        $count_order_shipped = Order::where('status', '=', "shipped")->count();
        $count_order_delivered = Order::where('status', '=', "delivered")->count();
        $count_order_canceled = Order::where('status', '=', "canceled")->count();
        $count_total_amount = Order::where('total_amount')->count();
        $count_total_product = Product::count();
        $count_sale_product = Product::where('product_status', '=', "active")->count();

        // $count_order_trash = Order::onlyTrashed()->count();


        $count = [
            'all' => $count_order_all,
            'pending' => $count_order_pending,
            'processing' => $count_order_processing,
            'shipped' => $count_order_shipped,
            'delivered' => $count_order_delivered,
            'canceled' => $count_order_canceled,
            'total_amount' => $count_total_amount,
            'total_product' => $count_total_product,
            'sale_product'=> $count_sale_product,
        ];
        return view('admin.dashboard', compact('new_orders', 'count'));
    }
 
    
    // public function delete(Request $request, $order_id) { 
    //     $new_orders = Order::find($order_id);
    //     $new_orders->delete();
    //     return redirect('dashboard')->with('status_success', 'Bản ghi đã được đưa vào thùng rác =))');
    // }
    
}
