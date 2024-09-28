<?php

namespace App\Http\Controllers;

use App\Models\Order_item;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Province;
use App\Models\Ward;
use App\Models\District;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;



class AdminOrderController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'order']);
            return $next($request);
        });
    }
    /////////////////////////////////////////// 
    function list(Request $request)
    {

        $status = $request->input('status');
        $list_act = [
            'delete' => 'xóa tạm thời'
        ];
        if ($status == "trash") {
            $list_act = [
                'restore' => 'khôi phục',
                'forceDelete' => 'xóa vĩnh viễn'
            ];
            $orders = Order::onlyTrashed()->orderBy('updated_at', 'desc')->paginate(10);
        } elseif ($status == "pending") {
            $orders = Order::where('status', '=', "pending")->orderBy('updated_at', 'desc')->paginate(10);
        } elseif ($status == "processing") {
            $orders = Order::where('status', '=', "processing")->orderBy('updated_at', 'desc')->paginate(10);
        } elseif ($status == "shipped") {
            $orders = Order::where('status', '=', "shipped")->orderBy('updated_at', 'desc')->paginate(10);
        } elseif ($status == "delivered") {
            $orders = Order::where('status', '=', "delivered")->orderBy('updated_at', 'desc')->paginate(10);
        } elseif ($status == "canceled") {
            $orders = Order::where('status', '=', "canceled")->orderBy('updated_at', 'desc')->paginate(10);
        } else {
            $keyword = "";
            if ($request->input('keyword')) {
                $keyword = $request->input('keyword');
            }
            $orders = Order::where('orders.order_id', 'LIKE', "%{$keyword}%")->orderBy('updated_at', 'desc')->paginate(5);
            // dd($orders);
            // dump($orders);
        }

        $count_order_all = Order::count();
        $count_order_pending = Order::where('status', '=', "pending")->count();
        $count_order_processing = Order::where('status', '=', "processing")->count();
        $count_order_shipped = Order::where('status', '=', "shipped")->count();
        $count_order_delivered = Order::where('status', '=', "delivered")->count();
        $count_order_canceled = Order::where('status', '=', "canceled")->count();
        $count_order_trash = Order::onlyTrashed()->count();


        $count = [
            $count_order_all,
            $count_order_pending,
            $count_order_processing,
            $count_order_shipped,
            $count_order_delivered,
            $count_order_canceled,
            $count_order_trash
        ];

        return view('admin.order.list', compact('orders', 'count', 'list_act'));

    }


    function delete(Request $request, $order_id)
    {
        $status = $request->input('status');
        if ($status == 'trash') {
            $order = Order::onlyTrashed()->find($order_id);
            $order->forceDelete();
            return redirect('admin/order/list')->with('status_success', 'Bạn đã xóa bảng ghi thành công =))');
        } else {
            $order = Order::find($order_id);
            $order->delete();
            return redirect('admin/order/list')->with('status_success', 'Bản ghi đã được đưa vào thùng rác =))');
        }
    }

    function action(Request $request)
    {
        $list_check = $request->input('list_check');
        if (!empty($list_check)) {
            $act = $request->input('act');
            if ($act == 'delete') {
                Order::destroy($list_check);
                return redirect('admin/order/list')->with('status_success', 'Bản ghi đã được đưa vào thừng rác =))');
            }
            if ($act == 'restore') {
                Order::withTrashed()
                    ->whereIn('order_id', $list_check)
                    ->restore();
                return redirect('admin/order/list')->with('status_success', 'Bạn đã khôi phục bản ghi thành công =))');
            }
            if ($act == 'forceDelete') {
                Order::withTrashed()
                    ->whereIn('order_id', $list_check)
                    ->forceDelete();
                return redirect('admin/order/list')->with('status_success', 'Bạn đã xóa bản ghi thành công =))');
            }
        } else {
            return redirect('admin/order/list')->with('status_danger', 'Bạn chưa chọn đối trượng !!!');
        }
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'fullname' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'address' => 'required',
                'ward' => 'required',
                'district' => 'required',
                'province' => 'required',
            ],
            [
                'required' => ':attribute Không được để trống !!!',
                'min' => ':attribute Có độ dài ít nhất :min ký tự !!!',
                'max' => ':attribute Có độ dài tối đa :max ký tự !!!',
            ],
            [
                'fullname' => 'Họ và tên',
                'email' => 'Email',
                'address' => 'Địa chỉ',
                'ward' => 'Phường/Xã',
                'district' => 'Quận/Huyện',
                'province' => 'Tỉnh/Thành phố',
            ]
        );
        //// get_province
        $province_id = $request->input('province');
        $province = Province::where('province_id', $province_id)->first('name');
        // dd($province);
        //// get_district
        $district_id = $request->input('district');
        $district = District::where('district_id', $district_id)->first('name');
        //// get_ward
        $ward = $request->input('ward');

        //// merge address
        $full_address = $request->input('address') . ', ' . $ward . ', ' . $district->name . ', ' . $province->name;
        // dd($full_address);
        $customer = Customer::create([
            'fullname' => $request->input('fullname'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone_number'),
            'address' => $full_address,
        ]);
        $order = Order::create(
            [
                'order_code' => "ORD12345",
                'product_quantity' => $request->input('product_quantity'),
                'total_amount' => $request->input('total_amount'),
                'order_date' => now(),
                'payment_method' => $request->input('payment_method'),
                'shipping_address' => $full_address,
                'status' => 'pending',
                'customer_id' => $customer->customer_id,
            ]
        );

        $cartItems = json_decode($request->input('cart_items'), true); // Converts JSON string to array
        // dd($cartItems);
        foreach ($cartItems as $item) {
            $order_item = Order_item::create([
                'order_id' => $order->order_id,
                'product_id' => $item['product_id'],
                'quantity' => $item['product_quantity'],
                'price' => $item['product_price'],
                'update_at' => null,
            ]);
        }
        // thực hiện xóa giỏ hàng sau khi hoàn thành đặt hàng
        session(['cart' => null]);
        $order_id = $order_item->order_id;
        // dd($order_id);

        return redirect()->route('order_success', ['order_id' => $order_id]);
    }


    public function edit(Request $request, $order_id)
    {
        $ordered = Order::where('order_id', $order_id)->get();
        foreach ($ordered as $item) {
            $customer_details = Customer::where('customer_id', $item->customer_id)->get();
        }
        $order_item = Order_item::where('order_id', $order_id)->get();
        // dd($ordered);
        return view('admin.order.detail', compact('order_item', 'ordered'));
    }
    public function update(Request $request, $order_id)
    {
        Order::where('order_id', $order_id)->update(
           [
                'status' => $request->input('status'),
            ]
        );
        return redirect('admin/order/list')->with('status_success', 'Bạn đã cập nhật bảng ghi thành công =))');
    }
    

}

