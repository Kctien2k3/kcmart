@extends('layouts.app')

@section('content')
    <div id="main-content-wp" class="clearfix detail-product-page">
        <div class="wp-inner">
            <div class="secion" id="breadcrumb-wp">
                <div class="secion-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="{{route('home')}}" title="">Trang chủ</a>
                        </li>
                        

                    </ul>
                </div>
            </div>

            <div class="main-content fl-right">
                @foreach ($product_detail as $item)
                    <div class="section" id="detail-product-wp">
                        <div class="section-detail clearfix">
                            <div class="thumb-wp fl-left">
                                <a title="" id="main-thumb">
                                    <img id="zoom" src="{{ $item->image->image_url ?? '' }}"
                                        data-zoom-image="{{ $item->image->image_url ?? '' }}" />
                                </a>
                                <div id="list-thumb">
                                    @foreach ($product_images as $image)
                                        <a href="" data-image="{{ $image->image->image_url ?? '' }}"
                                            data-zoom-image="{{ $image->image->image_url ?? '' }}">
                                            <img id="zoom" src="{{ $image->image->image_url ?? '' }}" />
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                            <div class="thumb-respon-wp fl-left">
                                <img src="public/images/img-pro-01.png" alt="">
                            </div>
                            <div class="info fl-right">
                                <h3 class="product-name">{{ $item->product_title ?? '' }}</h3>
                                <div class="desc">
                                    {{ $item->product_desc ?? '' }}
                                </div>
                                <div class="num-product">
                                    <span class="title">Sản phẩm: </span>
                                    <span
                                        class="status">{{ $item->product_status == 'active' ? 'Còn hàng' : 'hết hàng' }}</span>
                                </div>
                               <div>
                                    <span class="price">{{ number_format($item->product_price) }} vnđ </span>
                                    <span class="h5 text-secondary text-decoration-line-through">{{ number_format($item->product_oldPrice) ?? '' }} vnđ</span>
                                    <span>({{ round((($item->product_price - $item->product_oldPrice) / $item->product_oldPrice) * 100, 2) }}%)</span>
                               </div>
                                <div id="add-to-cart">
                                    <div id="num-order-wp">
                                        <button class="addQuantity btn-minus btn btn-light">--</button>
                                        <input type="text" id="num-order" data-id="{{ $item->product_id }}"
                                            value="1" class="num-order qty-input" min="1">
                                        <button class="addQuantity btn-plus btn btn-light">+</button>
                                        {{-- ///// button add  --}}
                                    </div>
                                    <button title="Thêm giỏ hàng" class="add-cart" id="add_product">Thêm giỏ hàng</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="section" id="post-product-wp">
                        <div class="section-head">
                            <h3 class="section-title">Mô tả sản phẩm</h3>
                        </div>
                        <div class="section-detail">
                            {{ $item->product_details ?? '' }}
                        </div>
                    </div>
                @endforeach
                <div class="section" id="same-category-wp">
                    @if (!empty($list_product_by_cat_id))
                        <div class="section-head">
                            <h3 class="section-title">Cùng chuyên mục</h3>
                        </div>
                        <div class="section-detail">
                            <ul class="list-item">
                                @foreach ($list_product_by_cat_id as $item)
                                    @if ($item->product_id != $product_id)
                                        <li>
                                            <a href="{{ route('detail.product', ['product_slug' => $item->product_slug]) }}" title=""
                                                class="thumb d-flex justify-content-center">
                                                <img src="{{ url($item->image->image_url) }}" style="height: 140px">
                                            </a>
                                            <a href="{{ route('detail.product', ['product_slug' => $item->product_slug]) }}" 
                                                class="product-name text-truncate" 
                                                style="max-width: 250px;" 
                                                data-bs-toggle="tooltip" 
                                                data-bs-placement="bottom" 
                                                title="{{ $item->product_title }}">
                                                {{ $item->product_title }}
                                             </a>
                                            <div class="price">
                                                <span class="new">{{ number_format($item->product_price) }}đ</span>
                                                <span class="old">{{ number_format($item->product_price) }}đ</span>
                                            </div>
                                            <div class="action clearfix">
                                                <a href="{{ route('cart.add', $item->product_id) }}" title=""
                                                    class="add-cart fl-left btn btn-outline-dark py-2">Thêm giỏ hàng</a>
                                                <a href="{{ route('cart.add', ['product_id' => $item->product_id, 'buy_now' => true]) }}"
                                                    title="" name="buy_now" class="buy-now fl-right btn btn-outline-danger py-2">Mua ngay</a>
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @else
                        không có gì
                    @endif
                </div>
            </div>

            {{-- //////////////////////////////////////////////////////////////////////////////////////////////////// --}}
            @include('layouts.sidebar')
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.btn-plus').click(function(e) {
                e.preventDefault();
                var incre_value = $(this).parents('#add-to-cart').find('#num-order').val();
                var value = parseInt(incre_value, 10);
                value = isNaN(value) ? 0 : value;
                value++;
                $(this).parents('#add-to-cart').find('#num-order').val(value);
            });

            $('.btn-minus').click(function(e) {
                e.preventDefault();
                var decre_value = $(this).parents('#add-to-cart').find('#num-order').val();
                var value = parseInt(decre_value, 10);
                value = isNaN(value) ? 0 : value;
                if (value > 1) {
                    value--;
                    $(this).parents('#add-to-cart').find('#num-order').val(value);
                }
            });
        });
    </script>
    {{-- @if (session('Msg_success'))
        <script>
            Swal.fire({
                icon: "success",
                title: "Sản phẩm đã được thêm vào giỏ hàng",
                showConfirmButton: false,
                timer: 3000,
                customClass: {
                    title: 'custom-title', // Thêm class tùy chỉnh cho title
                }
            });
        </script>
        <!-- Thêm CSS cho các class tùy chỉnh -->
        <style>
            .custom-title {
                color: #000000;
                /* Màu xanh lá cây cho text */
                font-size: 22px;
                /* Cỡ chữ */
                font-weight: bold;
                /* In đậm chữ */
            }
        </style>
    @endif --}}


    <script>
        $(document).ready(function() {
            $('#add_product').click(function() {
                Swal.fire({
                    icon: "success",
                    title: "Sản phẩm đã được thêm vào giỏ hàng",
                    showConfirmButton: false,
                    timer: 4000,
                    customClass: {
                        title: 'custom-title', // Thêm class tùy chỉnh cho title
                    }
                });
            })
        })
    </script>
    <style>
        .custom-title {
            color: #000000;
            /* Màu xanh lá cây cho text */
            font-size: 22px;
            /* Cỡ chữ */
            font-weight: bold;
            /* In đậm chữ */
        }
    </style>
    <script>
        $(document).ready(function() {
            $('.add-cart').click(function() {
                Swal.fire({
                    icon: "success",
                    title: "Sản phẩm đã được thêm vào giỏ hàng",
                    showConfirmButton: false,
                    timer: 4000,
                    customClass: {
                        title: 'custom-title', // Thêm class tùy chỉnh cho title
                    }
                });
            })
        })
    </script>
    <style>
        .custom-title {
            color: #000000;
            /* Màu xanh lá cây cho text */
            font-size: 22px;
            /* Cỡ chữ */
            font-weight: bold;
            /* In đậm chữ */
        }
    </style>
@endsection
