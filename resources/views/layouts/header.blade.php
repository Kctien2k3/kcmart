<!DOCTYPE html>
<html>

<head>
    <title>ISMART STORE</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- ///////////////////////////////////////////////////////////////// mấu chốt để tạo css/js tương đối chạy đa nền tảng  --}}
    <base href="http://localhost/UNITOP.VN/BACK-END/LARAVEL/PROJECTS/Unimart.com/">
    {{-- ///////////////////////////////////////////////////////////////// mấu chốt để tạo css/js tương đối chạy đa nền tảng  --}}

    {{-- <link href="public/css/bootstrap/bootstrap-theme.min.css" rel="stylesheet" type="text/css" /> --}}
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css"
        integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous"> --}}
    {{-- <link href="public/css/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css" /> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    {{-- <link href="public/reset.css" rel="stylesheet" type="text/css" /> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css"
        integrity="sha512-NmLkDIU1C/C88wi324HBc+S2kLhi08PN5GDeUVVVC/BVt/9Izdsc9SVeVfA1UZbY3sHUlDSyRXhCzHfr6hmPPw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="public/css/carousel/owl.carousel.css" rel="stylesheet" type="text/css" />
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css"
        integrity="sha512-UTNP5BXLIptsaj5WdKFrkFov94lDx+eBvbKyoe1YAfjeRPC+gT5kyZ10kOHCfNZqEui1sxmqvodNUx3KbuYI/A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
    <link href="public/css/carousel/owl.theme.css" rel="stylesheet" type="text/css" />
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css"
        integrity="sha512-OTcub78R3msOCtY3Tc6FzeDJ8N9qvQn1Ph49ou13xgA9VsH9+LRxoFU6EqLhW4+PKRfU+/HReXmSZXHEkpYoOA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
    {{-- <link href="public/css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" /> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- /// --}}
    <link href="public/style.css" rel="stylesheet" type="text/css" />
    <link href="public/ responsive.css" rel="stylesheet" type="text/css" />

    {{-- <script src="public/js/jquery-2.2.4.min.js" type="text/javascript"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{-- <script src="public/js/elevatezoom-master/jquery.elevatezoom.js" type="text/javascript"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/elevatezoom/2.2.3/jquery.elevatezoom.js"
        integrity="sha512-EjW7LChk2bIML+/kvj1NDrPSKHqfQ+zxJGBUKcopijd85cGwAX8ojz+781Rc0e7huwyI3j5Bn6rkctL3Gy61qw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{-- <script src="public/js/bootstrap/bootstrap.min.js" type="text/javascript"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js"
        integrity="sha512-ykZ1QQr0Jy/4ZkvKuqWn4iF3lqPZyij9iRv6sGqLRdTPkY69YX6+7wvVGmsdBbiIfN/8OdsI7HABjvEok6ZopQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    {{-- ///// --}}
    <script src="public/js/carousel/owl.carousel.js" type="text/javascript"></script>
    <script src="public/js/main.js" type="text/javascript"></script>
    <script src="public/js/ajax.js" type="text/javascript"></script>
    {{-- //////// thêm mã  Token CSRF để tránh lỗi gửi ajax --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- ///////////////// thông báo --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>



</head>

<body>
    <div id="site">
        <div id="container">
            <div id="header-wp">
                <div id="head-top" class="clearfix">
                    <div class="wp-inner">
                        <a href="" title="" id="payment-link" class="fl-left">Hình thức thanh toán</a>
                        <div id="main-menu-wp" class="fl-right">
                            {{-- @if (!empty($menu_header)) --}}
                            <ul id="main-menu" class="clearfix">
                                {{-- @foreach ($menu_header as $item) --}}
                                <li>
                                    <a href="{{ route('home') }}" title="">Trang chủ</a>
                                </li>
                                <li>
                                    <a href="{{ route('post', ['']) }}" title="">Tin tức - Sự kiện</a>
                                </li>
                                <li>
                                    <a href="{{ route('about') }}" title="">Giới thiệu</a>
                                </li>
                                <li>
                                    <a href="{{ route('contact') }}" title="">Liên hệ</a>
                                </li>
                            </ul>
                            {{-- @endif --}}
                        </div>
                    </div>
                </div>
                <div id="head-body" class="clearfix">
                    <div class="wp-inner">
                        <a href="{{url('/')}}" title="" id="logo" class="fl-left"><img
                                src="https://cdn2.fptshop.com.vn/unsafe/150x0/filters:quality(100)/small/fptshop_logo_c5ac91ae46.png" /></a>
                        <div id="search-wp" class="fl-left">
                            <form method="POST" action="{{ route('search') }}">
                                @csrf
                                <input type="text" name="keyword" id="s"
                                    value=""
                                    placeholder="Nhập từ khóa tìm kiếm tại đây!" class="rounded ">
                                <button type="submit" class="rounded" id="sm-s">Tìm kiếm</button>
                            </form>
                        </div>
                        <div id="action-wp" class="fl-right">
                            <div id="advisory-wp" class="fl-left">
                                <span class="title">HotLine Tư vấn</span>
                                <span class="phone">0971.380.103</span>
                            </div>
                            <div id="btn-respon" class="fl-right"><i class="fa fa-bars" aria-hidden="true"></i></div>
                            <a href="" title="giỏ hàng" id="cart-respon-wp" class="fl-right">
                                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                <span id="num">2</span>
                            </a>
                            <div id="cart-wp" class="fl-right">
                                <div id="btn-cart">
                                    <a href="{{ route('cart') }}" class="text-light"><i
                                            class="fa-solid fa-cart-arrow-down sm"></i></a>
                                    <span id="num">{{ $cart->totalQuantity }}</span>
                                </div>
                                <div id="dropdown">
                                    @if ($cart->totalQuantity > 0)
                                        <p class="desc">Có <span>{{ $cart->totalQuantity }} sản phẩm</span> trong giỏ
                                            hàng</p>
                                        <ul class="list-cart overflow-auto" style="max-height: 250px;">
                                            @foreach ($cart->carts as $item)
                                                <li class="clearfix">
                                                    <a href="" title="" class="thumb fl-left">
                                                        <img src="{{ $item->product_image }}" alt="">
                                                    </a>
                                                    <div class="info fl-right">
                                                        <a href="" title=""
                                                            class="product-name">{{ $item->product_title }}</a>
                                                        <p class="price">
                                                            {{ number_format($item->product_price, 0, ',', '.') }} vnđ
                                                        </p>
                                                        <p class="qty">Số lượng:
                                                            <span>{{ $item->product_quantity }}</span>
                                                        </p>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>

                                        <div class="total-price clearfix">
                                            <p class="title fl-left">Tổng:</p>
                                            <p class="price fl-right">
                                                {{ number_format($cart->totalPrice, 0, ',', '.') }} vnd</p>
                                        </div>
                                        <dic class="action-cart clearfix ">
                                            <a href="{{ url('/cart') }}" title="Giỏ hàng"
                                                class="view-cart fl-left">Giỏ
                                                hàng</a>
                                            <a href="{{ url('/checkout') }}" title="Thanh toán"
                                                class="checkout fl-right">Thanh
                                                toán</a>
                                        </dic>
                                    @else
                                        <div class="text-center">
                                            <div class="d-flex justify-content-center align-items-center p-3"><img
                                                    src="https://kangarooshopping.vn/static/version1689569306/frontend/Kangaroo/base/vi_VN/images/cart-empty.png"
                                                    alt="" style="width: 6.75rem; height: 6.125rem; "
                                                    class="">
                                            </div>
                                            <div>
                                                <p class="text-dark">Chưa có sản phẩm</p>
                                            </div>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
