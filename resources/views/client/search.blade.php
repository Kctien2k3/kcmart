@extends('layouts.app')

@section('content')
    <div id="main-content-wp" class="clearfix category-product-page">
        <div class="wp-inner">
            <div class="secion" id="breadcrumb-wp">
                <div class="secion-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="{{ route('home') }}" title="">Trang chủ</a>
                        </li>
                        {{-- <li>
                            <a href="" title="">{{ $category->category_name }}</a>
                        </li> --}}
                        <li>
                            <a href="" title="">Tìm kiếm sản phẩm</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="main-content fl-right">
                <div class="section" id="list-product-wp">
                    <div class="section-head clearfix">
                        <h3 class="section-title fl-left">KẾT QUẢ TÌM KIẾM CHO TỪ KHÓA "{{ $keyword }}"</h3><br>
                        <div class="filter-wp fl-right">
                            <p class="desc">Hiển thị {{$count_searchResult}} trên {{$count_searchResult}} sản phẩm</p>
                            <div class="form-filter">
                                <form method="POST" action="">
                                    <select name="select">
                                        <option value="0">Sắp xếp</option>
                                        <option value="1">Từ A-Z</option>
                                        <option value="2">Từ Z-A</option>
                                        <option value="3">Giá cao xuống thấp</option>
                                        <option value="3">Giá thấp lên cao</option>
                                    </select>
                                    <button type="submit">Lọc</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="section-detail">
                        <h6>Tìm được {{$count_searchResult}} kết quả phù hợp</h6>
                        @if (!empty($products))
                            <ul class="list-item clearfix">
                                @foreach ($products as $item)
                                    @if ($item->product_status == 'active' || $item->product_status == 'out_of_stock')
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
                <div class="section" id="paging-wp">
                    <div class="section-detail d-flex justify-content-center">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
            {{-- ////////////// --}}
            @include('layouts.sidebar')
            {{-- ///////////////////// --}}
        </div>
    </div>

    @if (session('Msg_success'))
        <script>
            Swal.fire({
                icon: "success",
                title: "Sản phẩm đã được thêm vào giỏ hàng",
                showConfirmButton: false,
                timer: 2500,
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
