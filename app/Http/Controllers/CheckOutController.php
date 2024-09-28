<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\District;
use App\Models\Ward;
use App\Models\Order;
use App\Models\Order_item;
use App\Models\Customer;

class CheckOutController extends Controller
{
    //
    public function checkout(Request $request)
    {
        $province = Province::get();

        return view('client.checkout.show', compact('province'));
    }

    public function district(Request $request)
    {
        //// Get data from district table and handle it 
        $province_id = $request->get('province_id');
        // dd($province_id);
        $districts = District::where('province_id', $province_id)->get();
        $data[0] = [
            'id' => null,
            'name' => 'chọn một quận/huyện',
        ];
        foreach ($districts as $item) {
            $data[] = [
                'id' => $item['district_id'],
                'name' => $item['name']
            ];
        }
        ;
        // $data['district'] = District::where('province_id', $province_id)->get(['name', 'district_id']);
        return response()->json($data);
    }
    public function ward(Request $request)
    {
        //// Get data from district table and handle it 
        $district_id = $request->get('district_id');
        // dd($province_id);
        $wards = Ward::where('district_id', $district_id)->get();
        $data[0] = [
            'id' => null,
            'name' => 'chọn một phường/xã',
        ];
        foreach ($wards as $item) {
            $data[] = [
                'id' => $item['ward_id'],
                'name' => $item['name']
            ];
        }
        ;
        return response()->json($data);
    }


    public function orderSuccess(Request $request, $order_id)
    {
        $ordered = Order::where('order_id', $order_id)->get();
        foreach ($ordered as $item) {
            $customer_details = Customer::where('customer_id', $item->customer_id)->get();
        }
        $order_item = Order_item::where('order_id', $order_id)->get();
        // dd($product);
        return view('client.checkout.orderSuccess', compact('order_item', 'customer_details', 'ordered'));
    }
}
