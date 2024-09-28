@extends('layouts.app')

@section('content')
    <div id="main-content-wp" class="checkout-page">
        <div class="section" id="breadcrumb-wp">
            <div class="wp-inner">
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="{{ url('/') }}" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="{{ url('/checkout') }}" title="">Thanh toán</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <form action="{{ url('admin/order/store') }}" method="POST">
            @csrf
            <div id="wrapper" class="wp-inner clearfix">
                <div class="section" id="customer-info-wp">
                    <div class="section-head">
                        <h1 class="section-title">Thông tin khách hàng</h1>
                    </div>
                    <div class="section-detail">
                        <form method="GET" action="" name="form-checkout" enctype="multipart/form-data">
                            <div class="form-row clearfix">
                                <div class="form-col fl-left">
                                    <label for="fullname" class="fw-bold">Họ tên <span
                                            class="text-danger">(*)</span></label>
                                    <input type="text" name="fullname" id="fullname" class="form-control">
                                    @error('fullname')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-col fl-right">
                                    <label for="phone" class="fw-bold">Số điện thoại <span
                                            class="text-danger">(*)</span></label>
                                    <input type="tel" name="phone_number" id="phone" class="form-control">
                                    @error('phone_number')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row clearfix">
                                <div class="form-col-12" style="padding-bottom: 15px;">
                                    <label for="email" class="fw-bold" style="padding-bottom: 10px;">Email <span
                                            class="text-danger">(*)</span></label>
                                    <input type="email" name="email" id="email" class="form-control"
                                        placeholder="@gmail.com">
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-col-12" style="padding-bottom: 15px;">
                                    <label for="address" class="fw-bold" style="padding-bottom: 10px;">Địa chỉ <span
                                            class="text-danger">(*)</span></label>
                                    <input type="text" name="address" id="address" class="form-control"
                                        placeholder="vd: 200 Đ.Ung văn khiêm">
                                    @error('address')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-col-12" style="padding-bottom: 15px;">
                                    <label for="province" class="fw-bold" style="padding-bottom: 10px;">Tỉnh/Thành phố <span
                                            class="text-danger">(*)</span></label>
                                    <select name="province" id="province" class="form-control">
                                        <option value="0">-- Chọn một tỉnh/thành phố --</option>
                                        @foreach ($province as $item)
                                            <option value="{{ $item->province_id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('province')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-col-12" style="padding-bottom: 15px;">
                                    <label for="district" class="fw-bold" style="padding-bottom: 10px;">Quận/Huyện <span
                                            class="text-danger">(*)</span></label>
                                    <select name="district" id="district" class="form-control">
                                        <option value="0">-- Chọn một quận/huyện --</option>
                                    </select>
                                    @error('district')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-col-12" style="padding-bottom: 15px;">
                                    <label for="ward" class="fw-bold" style="padding-bottom: 10px;">Phường/Xã <span
                                            class="text-danger">(*)</span></label>
                                    <select name="ward" id="ward" class="form-control">
                                        <option value="0">-- Chọn một phường/xã --</option>
                                    </select>
                                    @error('ward')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row clearfix">
                                <div class="form-col" style="padding-bottom: 15px;">
                                    <label for="notes" class="fw-bold" style="padding-bottom: 10px;">Ghi chú</label>
                                    <textarea name="note" class="form-control"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="section" id="order-review-wp">
                    <div class="section-head">
                        <h1 class="section-title">Thông tin đơn hàng</h1>
                    </div>
                    <div class="section-detail">
                        <table class="shop-table">
                            <thead>
                                <tr>
                                    <td class="fw-bold">Sản phẩm</td>
                                    <td class="fw-bold">Tổng</td>
                                </tr>
                            </thead>
                            <tbody>
                                <input type="hidden" name="cart_items" value="{{ json_encode($cart->carts) }}">
                                @foreach ($cart->carts as $item)
                                    <tr class="cart-item">
                                        <td class="product-name ">{{ $item->product_title }}<strong
                                                class="product-quantity text-warning">x
                                                {{ $item->product_quantity }}</strong>
                                        </td>
                                        <td class="product-total">
                                            {{ number_format($item->product_price * $item->product_quantity, 0, ',', '.') }}
                                            vnđ</td>
                                    </tr>
                                @endforeach
                                <input type="hidden" name="product_quantity" value="{{ $cart->totalQuantity }}">

                            </tbody>
                            <tfoot>
                                <tr class="order-total">
                                    <td class="fw-bold">Tổng đơn hàng:</td>
                                    <td><strong class="total-price">{{ number_format($cart->totalPrice, 0, ',', '.') }}
                                            vnd</strong></td>
                                </tr>
                                <input type="hidden" name="total_amount" value="{{ $cart->totalPrice }}">

                            </tfoot>
                        </table>
                        <div id="payment-checkout-wp">
                            <ul id="payment_methods">
                                <li>
                                    <input type="radio" id="direct-payment" name="payment_method"
                                        value="Online payment">
                                    <label for="direct-payment">Thanh toán bằn ví điện tử</label>
                                </li>
                                <li>
                                    <input type="radio" id="payment-home" name="payment_method" value="COD"
                                        checked>
                                    <label for="payment-home">Thanh toán tại nhà</label>
                                </li>
                            </ul>
                        </div>
                        <div class="place-order-wp clearfix">
                                <input type="submit" id="order-now" value="Đặt hàng">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
