@extends('layouts.app')

@section('content')
    <div id="main-content-wp" class="cart-page">
        <div class="section" id="breadcrumb-wp">
            <div class="wp-inner">
                <div class="section-detail">
                    <ol class="list-item clearfix" class="">
                        <li>
                            <a href="{{ url('/') }}" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="{{ url('/cart') }}" title="">Đặt hàng thành công</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
        <div id="wrapper" class="wp-inner clearfix">
            <div class="section mb-4">
                <div class="display-1 text-center text-success"><i class="fa-solid fa-circle-check"></i></div>
                <p class="h4 text-center text-success mb-3">Đặt hàng thành công</p>
                <p class="h6 text-center">Cảm ơn quý khách đã đặt hàng tại <span class="mark">KcShop</span> của chúng tôi
                </p>
                <p class="h6 text-center">Thông tin đơn hàng đã được gửi vào email của quý khách, quý khách vui lòng kiểm
                    tra email của mình!</p>
                <p class="h6 text-center">Nhân viên của chúng tôi sẽ liên hệ với quý khách để xác nhận đơn hàng, thời gian
                    giao hàng chậm nhất là 48h</p>
            </div>
            <div class="section" id="info-cart-wp">
                @foreach ($ordered as $temp)
                    <div class="section-detail table-responsive">
                        <div>
                            <p class="h6 mb-3 fw-bold">Mã Đơn hàng: {{ $temp->order_code }}</p>
                        </div>
                        <div class="title">
                            <p class="h5 text-success fw-bold mb-3"><span><i class="fa-solid fa-circle-info"></i></span>
                                Thông tin Khách hàng</p>
                        </div>
                        <table class="table table-hover">
                            <thead class="table table-dark">
                                <tr>
                                    <th scope="col" class="text-center align-items-center">Họ và tên</th>
                                    <th scope="col" class="text-center align-items-center">Địa chỉ</th>
                                    <th scope="col" class="text-center align-items-center">Số điện thoại</th>
                                    <th scope="col" class="text-center align-items-center">Email</th>

                                    {{-- <th scope="col" class="text-center align-items-center">Ghi chú</th> --}}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customer_details as $item)
                                    <tr>
                                        <td scope="col" class="text-center align-items-center">{{ $item->fullname }}</td>
                                        <td scope="col" class="text-center align-items-center">{{ $item->address }}</td>
                                        <td scope="col" class="text-center align-items-center">{{ $item->phone_number }}
                                        </td>
                                        <td scope="col" class="text-center align-items-center">{{ $item->email }}</td>
                                        {{-- <td scope="col" class="text-center align-items-center"></td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="section-detail table-responsive">
                        <div class="title">

                            <p class="h5 text-success fw-bold mb-3 mt-3"><span><i
                                        class="fa-solid fa-circle-info"></i></span> Thông tin sản phẩm đã mua</p>
                        </div>
                        <table class="table table-hover">
                            <thead class="table table-dark">
                                <tr>
                                    <th scope="col" class="text-center align-items-center">STT</th>
                                    <th scope="col" class="text-center align-items-center">Ảnh sản phẩm</th>
                                    <th scope="col" class="text-center align-items-center">Tên sản phẩm</th>
                                    <th scope="col" class="text-center align-items-center">Giá sản phẩm</th>
                                    <th scope="col" class="text-center align-items-center">Số lượng</th>
                                    <th scope="col" class="text-center align-items-center">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $t = 0;
                                @endphp
                                @foreach ($order_item as $item)
                                    @php
                                        $t++;
                                    @endphp
                                    <tr>
                                        <td>{{ $t }}</td>
                                        <td scope="col" class="text-center">
                                            <a title="" class="d-flex justify-content-center">
                                                <img src="{{ $item->product->image->image_url ?? '' }}" alt="current_image"
                                                    style="max-height: 70px;"
                                                    class="object-fit-fill border rounded align-middle">
                                            </a>
                                        </td>
                                        <td scope="col" class="product-name text-truncate" style="max-width: 130px;"
                                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                                            title="{{ $item->product->product_title ?? '' }}">
                                            <div class="product_title">
                                                {{ $item->product->product_title ?? '' }}
                                            </div>
                                        </td>
                                        <td scope="col" id="price" class="text-center align-items-center">
                                            {{ number_format($item->price, 0, ',', '.') ?? '' }} vnđ</td>
                                        <td scope="col" class="text-center align-items-center">
                                            <input type="text" value="{{ $item->quantity }}" class="num-order" readonly>
                                        </td>
                                        <td scope="col" class="sub-total text-center align-items-center">
                                            {{ number_format($sub_total = $item->price * $item->quantity, 0, ',', '.') }}
                                            vnđ</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <table class="table table-secondary mt-1">

                            <body>
                                <tr>
                                    <td>
                                        <p id="total-price" class="text-danger fw-bold">Tổng thanh toán
                                            ({{ $temp->product_quantity }}
                                            Sản phẩm)
                                            :</p>
                                    </td>
                                    <td colspan="">
                                        <div id="total-price" class="fl-right text-danger">
                                            <span
                                                style="margin-left: 250px; padding: 10px 75px;">{{ number_format($temp->total_amount, 0, ',', '.') }}
                                                vnd</span>
                                        </div>
                                    </td>
                                </tr>
                            </body>
                        </table>
                        <div class="text-center h6 mt-5">
                            <p class="py-1">Trước khi giao nhân viên sẽ liên hệ quý khách để xác nhận!</p>
                            <p>Khi cần trợ giúp vui lòng liên hệ cho chúng tôi qua hotline: <span
                                    class="text-primary">097******</span></p>
                            <a href="{{ url('/') }}"><button class="text-uppercase mt-3 btn btn-warning px-5">về
                                    Trang chủ</button></a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
