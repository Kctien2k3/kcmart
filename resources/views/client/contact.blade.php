@extends('layouts.app')

@section('content')
<div id="main-content-wp" class="clearfix blog-page">
    <div class="wp-inner">
        <div class="secion" id="breadcrumb-wp">
            <div class="secion-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="{{url('/')}}" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a title="">Liên hệ</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-content fl-right">
            <div class="section" id="list-blog-wp">
                <div class="section-head clearfix">
                    <h3 class="section-title">Liên hệ</h3>
                </div>
                <div class="section-detail">
                    
                </div>
            </div>
            <div class="section" id="paging-wp">
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="" title="">1</a>
                        </li>
                        <li>
                            <a href="" title="">2</a>
                        </li>
                        <li>
                            <a href="" title="">3</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="sidebar fl-left">
            <div class="section" id="selling-wp">
                <div class="section-head">
                    <h3 class="section-title">Sản phẩm bán chạy</h3>
                </div>
                <div class="section-detail">
                    <ul class="list-item overflow-auto" style="max-height: 500px;">
                        @foreach ($all_products as $item)
                            @if ($item->is_featured == 1)
                            <li class="clearfix">
                                <a href="{{ route('detail.product', ['product_slug' => $item->product_slug]) }}" title=""
                                    class="thumb fl-left">
                                    <img src="{{ $item->image->image_url }}" alt="">
                                </a>
                                <div class="info fl-right">
                                        <a href="{{ route('detail.product', ['product_slug' => $item->product_slug]) }}" 
                                            class="product-name" 
                                            style="max-width: 250px;" 
                                            data-bs-toggle="tooltip" 
                                            data-bs-placement="bottom" 
                                            title="{{ $item->product_title }}">
                                            {{ $item->product_title }}
                                         </a>
                                    <div class="price d-flex">
                                        <span class="new">{{ number_format($item->product_price) }}đ</span>
                                        <span class="old">{{ number_format($item->product_oldPrice) }}đ</span>
                                    </div>
                                    <a href="{{ route('cart.add', ['product_id' => $item->product_id, 'buy_now' => true]) }}"
                                        title="" name="buy_now" class="btn btn-outline-danger btn-sm px-3 ">Mua ngay</a>
                                </div>
                            </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="section" id="banner-wp">
                <div class="section-detail">
                    <a href="?page=detail_blog_product" title="" class="thumb">
                        <img src="public/images/banner.png" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection