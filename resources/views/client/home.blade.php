@extends('layouts.app')

@section('content')
    <div id="main-content-wp" class="home-page clearfix">
        <div class="wp-inner">
            <div class="main-content fl-right">
                <div class="section" id="slider-wp">
                    @if (!empty($sliders))
                        <div class="section-detail">
                            @foreach ($sliders as $slider)
                                <div class="item">
                                    <img src="{{ $slider->image->image_url }}" alt="current image" style="max-with: 877px; max-height: 390px;">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="section" id="support-wp">
                    <div class="section-detail">
                        <ul class="list-item clearfix">
                            <li>
                                <div class="thumb">
                                    <img src="public/images/icon-1.png">
                                </div>
                                <h3 class="title">Miễn phí vận chuyển</h3>
                                <p class="desc">Tới tận tay khách hàng</p>
                            </li>
                            <li>
                                <div class="thumb">
                                    <img src="public/images/icon-2.png">
                                </div>
                                <h3 class="title">Tư vấn 24/7</h3>
                                <p class="desc">1900.9999</p>
                            </li>
                            <li>
                                <div class="thumb">
                                    <img src="public/images/icon-3.png">
                                </div>
                                <h3 class="title">Tiết kiệm hơn</h3>
                                <p class="desc">Với nhiều ưu đãi cực lớn</p>
                            </li>
                            <li>
                                <div class="thumb">
                                    <img src="public/images/icon-4.png">
                                </div>
                                <h3 class="title">Thanh toán nhanh</h3>
                                <p class="desc">Hỗ trợ nhiều hình thức</p>
                            </li>
                            <li>
                                <div class="thumb">
                                    <img src="public/images/icon-5.png">
                                </div>
                                <h3 class="title">Đặt hàng online</h3>
                                <p class="desc">Thao tác đơn giản</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="section" id="feature-product-wp">
                    <div class="section-head">
                        <h3 class="section-title">Sản phẩm nổi bật</h3>
                    </div>
                    <div class="section-detail">
                        @if (!empty($all_products))
                            <ul class="list-item">
                                @foreach ($all_products as $item)
                                    @if ($item->is_featured == 1)
                                        <li>
                                            <a href="{{ route('detail.product', $item->product_slug) }}" title=""
                                                class="thumb d-flex justify-content-center">
                                                <img src="{{ $item->image->image_url }}" alt="current_image"
                                                    style="height: 140px">
                                            </a>
                                            <a href="{{ route('detail.product', ['product_slug' => $item->product_slug]) }}"
                                                class="product-name text-truncate" style="max-width: 250px;"
                                                data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                title="{{ $item->product_title }}">
                                                {{ $item->product_title }}
                                            </a>
                                            <div class="price">
                                                <span class="new">{{ number_format($item->product_price) }}đ</span>
                                                <span class="old">{{ number_format($item->product_oldPrice) }}đ</span>
                                            </div>
                                            <div class="action clearfix">
                                                <a href="{{ route('cart.add', $item->product_id) }}" title=""
                                                    class="add-cart fl-left btn btn-outline-dark py-2">Thêm giỏ hàng</a>
                                                <a href="{{ route('cart.add', ['product_id' => $item->product_id, 'buy_now' => true]) }}"
                                                    title="" name="buy_now"
                                                    class="buy-now fl-right btn btn-outline-danger py-2">Mua ngay</a>
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
                <div class="section" id="feature-product-wp">
                    @foreach ($product_cats as $cat)
                        <div class="">
                            <div class="section-head">
                                {{-- @if ($cat->parent_id == '0') --}}
                                <h3 class="section-title">{{ $cat->category_name }}</h3>
                                {{-- @endif --}}
                            </div>
                            <div class="section-detail d-flex">
                                <ul class="list-item clearfix">
                                    @foreach ($cat->childs as $list)
                                        @foreach ($list->products as $product)
                                            <li class="my-2">
                                                <a href="{{ route('detail.product', $product->product_slug) }}"
                                                    title="" class="thumb d-flex justify-content-center">
                                                    <img src="{{ $product->image->image_url }}" alt="current_image"
                                                        style="height: 140px">
                                                </a>
                                                <a href="{{ route('detail.product', ['product_slug' => $product->product_slug]) }}"
                                                    class="product-name text-truncate" style="max-width: 250px;"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    title="{{ $product->product_title }}">
                                                    {{ $product->product_title }}
                                                </a>
                                                <div class="price">
                                                    <span
                                                        class="new">{{ number_format($product->product_price) }}đ</span>
                                                    <span
                                                        class="old">{{ number_format($product->product_oldPrice) }}đ</span>
                                                </div>
                                                <div class="action clearfix">
                                                    <a href="{{ route('cart.add', $product->product_id) }}" title=""
                                                        class="add-cart fl-left btn btn-outline-dark py-2">Thêm giỏ hàng</a>
                                                    <a href="{{ route('cart.add', ['product_id' => $product->product_id, 'buy_now' => true]) }}"
                                                        title="" name="buy_now"
                                                        class="buy-now fl-right btn btn-outline-danger py-2">Mua ngay</a>
                                                </div>
                                            </li>
                                        @endforeach
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            {{-- /////////////////////// --}}
            @include('layouts.sidebar')
            {{-- ////////////////////// --}}

        </div>
    </div>

    @if (session('Msg_success'))
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
    @endif

@endsection
