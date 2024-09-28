@extends('layouts.app')

@section('content')
<style>
.product_title {
    color: black;
}
.product_title:hover {
    color: rgb(229, 195, 29)
}
</style>
    <div id="main-content-wp" class="cart-page">
        <div class="section" id="breadcrumb-wp">
            <div class="wp-inner">
                <div class="section-detail">
                    <ol class="list-item clearfix" class="">
                        <li>
                            <a href="{{ url('/') }}" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="{{ url('/cart') }}" title="">Giỏ hàng</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
        <div id="wrapper" class="wp-inner clearfix">
            @if (!empty($cart->carts))
                <div class="section" id="info-cart-wp">
                    <div class="section-detail table-responsive">

                        <table class="table table-hover">
                            <thead class="table table-dark">
                                <tr>
                                    <th scope="col" class="text-center align-items-center">STT</th>
                                    <th scope="col" class="text-center align-items-center">Ảnh sản phẩm</th>
                                    <th scope="col" class="text-center align-items-center">Tên sản phẩm</th>
                                    <th scope="col" class="text-center align-items-center">Giá sản phẩm</th>
                                    <th scope="col" class="text-center align-items-center">Số lượng</th>
                                    <th scope="col" class="text-center align-items-center">Thành tiền</th>
                                    <th scope="col" class="text-center align-items-center">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $t = 0;
                                @endphp
                                @foreach ($cart->carts as $item)
                                    @php
                                        $t++;
                                    @endphp
                                    <tr>
                                        <td>{{ $t }}</td>
                                        <td scope="col" class="text-center">
                                            <a href="{{ route('detail.product', ['product_slug' => $item->product_slug]) }}"
                                                title="" class="d-flex justify-content-center">
                                                <img src="{{ $item->product_image }}" alt="current_image"
                                                    style="max-height: 70px;"
                                                    class="object-fit-fill border rounded align-middle">
                                            </a>
                                        </td>
                                        <td scope="col" class="product-name text-truncate" style="max-width: 150px;"
                                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                                            title="{{ $item->product_title }}">
                                            <a href="{{ route('detail.product', ['product_slug' => $item->product_slug]) }}" class="product_title">
                                                {{ $item->product_title }}
                                            </a>
                                        </td>
                                        <td scope="col" id="price" class="text-center">
                                            {{ number_format($item->product_price, 0, ',', '.') }} vnđ
                                        </td>
                                        <td scope="col" class="text-center">
                                            <div class="quantity d-flex justify-content-center align-items-center">
                                                <button class="changeQuantity btn-minus btn btn-light">--</button>
                                                <input type="text" id="num_order" data-id="{{ $item->product_id }}"
                                                    value="{{ $item->product_quantity }}"
                                                    class="num-order qty-input text-center" min="1">
                                                <button class="changeQuantity btn-plus btn btn-light">+</button>
                                            </div>
                                        </td>
                                        <td scope="col" class="sub-total text-center">
                                            {{ number_format($sub_total = $item->product_price * $item->product_quantity, 0, ',', '.') }}
                                            vnđ
                                        </td>
                                        <td scope="col" class="text-center">
                                            <a href="{{ route('cart.delete', $item->product_id) }}"
                                                class="del-product p-3 text-dark" data-bs-toggle="tooltip" title="Delete!">
                                                <button class="btn btn-outline-dark del-product">
                                                    <i class="fa-solid fa-trash-arrow-up"></i>
                                                </button>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                        <table class="table table-secondary mt-3">
                            <tr>
                                <td colspan="">
                                    <div class="">
                                        <p id="total-price" class="fl-right fw-bold text-danger">Tổng hóa đơn thanh toán
                                            ({{ $cart->totalQuantity }}
                                            Sản
                                            phẩm):
                                            <span
                                                style="margin-left: 190px; padding: 10px 60px;">{{ number_format($cart->totalPrice, 0, ',', '.') }}
                                                vnd</span>
                                        </p>
                                    </div>
                                </td>
                                <td colspan="">
                                    <div class="clearfix">
                                        <div class="fl-right">
                                            <a href="{{ route('checkout') }}" title=""><button
                                                    class="btn btn-warning text-Secondary"
                                                    style="margin-right: 50px; padding: 10px 45px;">Tiến hành đặt
                                                    hàng</button></a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="section" id="action-cart-wp">
                    <div class="section-detail text-center">
                        {{-- <p class="title">Click vào <span>“Cập nhật giỏ hàng”</span> để cập nhật số lượng. Nhập vào số lượng
                        <span>0</span> để xóa sản phẩm khỏi giỏ hàng. Nhấn vào thanh toán để hoàn tất mua hàng.
                    </p> --}}
                        <div class="px-5">
                            <a href="{{ url('/') }}" title="" id="buy-more"><button
                                    class="btn btn-outline-warning px-5">Mua
                                    tiếp</button></a><br />
                        </div>
                        <div class="px-5">
                            <a href="{{ route('cart.clear') }}" title="" id="delete-cart"><button
                                    class="btn btn-dark px-5"><i class="fa-solid fa-trash-arrow-up"></i> Xóa giỏ
                                    hàng</button></a>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center">
                    <div class="d-flex justify-content-center align-items-center p-3"><img
                            src="https://kangarooshopping.vn/static/version1689569306/frontend/Kangaroo/base/vi_VN/images/cart-empty.png"
                            alt="" style="width: 6.75rem; height: 6.125rem; " class="">
                    </div>
                    <div>
                        <p class="h6">Giỏ hàng của bạn còn trống</p>
                    </div>
                    <div class="">
                        <a href="{{ url('/') }}"><button class="btn btn-warning px-5 shadow-lg mb-4">Mua
                                ngay</button></a>
                    </div>
                </div>
            @endif
        </div>
    </div>
    {{-- //////////////// tạo javascript button thêm bớt sản phẩm --}}
    <script>
        $(document).ready(function() {
            $('.btn-plus').click(function(e) {
                e.preventDefault();
                var incre_value = $(this).parents('.quantity').find('#num_order').val();
                var value = parseInt(incre_value, 10);
                value = isNaN(value) ? 0 : value;
                value++;
                $(this).parents('.quantity').find('#num_order').val(value);
            });

            $('.btn-minus').click(function(e) {
                e.preventDefault();
                var decre_value = $(this).parents('.quantity').find('#num_order').val();
                var value = parseInt(decre_value, 10);
                value = isNaN(value) ? 0 : value;
                if (value > 1) {
                    value--;
                    $(this).parents('.quantity').find('#num_order').val(value);
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.del-product').click(function(e) {
                e.preventDefault();
                const url = $(this).closest('a').attr('href');
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            })
        })

        $(document).ready(function() {
            $('#delete-cart').click(function(e) {
                e.preventDefault();
                const url = $(this).closest('a').attr('href');
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            })
        })
    </script>
    <!-- Thêm CSS cho các class tùy chỉnh -->

@endsection
