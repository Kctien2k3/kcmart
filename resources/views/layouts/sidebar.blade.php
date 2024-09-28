{{-- //////////////////////////////////////////////////////////////////////////////////////////////////// --}}
<div class="sidebar fl-left">
    <div class="section" id="category-product-wp">
        <div class="section-head">
            <h3 class="section-title">Danh mục sản phẩm</h3>
        </div>
        <div class="secion-detail"> 
            <ul class="list-item">
                @foreach ($product_cats as $cat_parent)
                    @if ($cat_parent->parent_id == '0')
                        <li>
                            <a href="{{ route('product.category', ['category_slug' => $cat_parent->category_slug]) }}"
                                title="">{{ $cat_parent['category_name'] }}
                            </a>
                            @include('layouts.child_menu', ['cat_parent' => $cat_parent])
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
    <div class="section" id="selling-wp">
        <div class="section-head">
            <h3 class="section-title">Sản phẩm bán chạy</h3>
        </div>
        <div class="section-detail">
            <ul class="list-item overflow-auto" style="max-height: 1000px;">
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
            <a href="" title="" class="thumb">
                <img src="public/images/banner.png" alt="">
            </a>
        </div>
    </div>
</div>

{{-- //////////////////////////////////////////////////////////////////////////////////////////////////// --}}
