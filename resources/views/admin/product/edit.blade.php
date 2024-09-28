@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header fw-bold">
                <h5 class="m-0 mt-2 mb-2 p-0 fw-bold"><i class="fa-solid fa-pen-to-square"></i> Chỉnh sửa chi tiết
                    sản phẩm</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('product.update', $product->product_id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            {{-- ////// --}}
                            <div class="form-group">
                                <label for="product_title" class="fw-bold my-2">Tên sản phẩm</label>
                                <input class="form-control" type="text" name="product_title" id="product_title"
                                    value="{{ $product->product_title }}">
                                @error('product_title')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            {{-- ///// --}}
                            <div class="form-group">
                                <label for="product_slug" class="fw-bold my-2">Slug</label>
                                <input class="form-control" type="text" name="product_slug" id="product_slug"
                                    value="{{ $product->product_slug }}">
                                @error('product_slug')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            {{-- ////// --}}
                            <div class="d-flex justify-content-betweet">

                                {{-- ////// --}}
                                <div class="form-group col-6 p-0 pl-3">
                                    <label for="product_price_display" class="fw-bold my-2">Giá (mới)</label>
                                    <input class="form-control" type="text" id="product_price_display"
                                        value="{{ old('product_price', isset($product) ? number_format($product->product_price, 0, ',', '.') : '') }}">
                                    <input type="hidden" name="product_price" id="product_price"
                                        value="{{ old('product_price', isset($product) ? $product->product_price : '') }}">
                                    @error('product_price')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <script>
                                    document.getElementById('product_price_display').addEventListener('input', function(e) {
                                        // Get the display input value and remove non-digit characters
                                        let displayValue = e.target.value.replace(/\D/g, '');

                                        // Update the hidden input with the raw numeric value
                                        document.getElementById('product_price').value = displayValue;

                                        // Format the display input value as currency
                                        e.target.value = new Intl.NumberFormat('vi-VN').format(displayValue);
                                    });
                                </script>
                                {{-- /////// --}}
                                <div class="form-group col-6 p-0 pl-3">
                                    <label for="product_oldPrice_display" class="fw-bold my-2">Giá (cũ)</label>
                                    <input class="form-control" type="text" id="product_oldPrice_display"
                                        value="{{ old('product_oldPrice', isset($product) ? number_format($product->product_oldPrice, 0, ',', '.') : '') }}">
                                    <input type="hidden" name="product_oldPrice" id="product_oldPrice"
                                        value="{{ old('product_oldPrice', isset($product) ? $product->product_oldPrice : '') }}">
                                    @error('product_price')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <script>
                                    document.getElementById('product_oldPrice_display').addEventListener('input', function(e) {
                                        // Get the display input value and remove non-digit characters
                                        let displayValue = e.target.value.replace(/\D/g, '');

                                        // Update the hidden input with the raw numeric value
                                        document.getElementById('product_oldPrice').value = displayValue;

                                        // Format the display input value as currency
                                        e.target.value = new Intl.NumberFormat('vi-VN').format(displayValue);
                                    });
                                </script>
                            </div>
                            {{-- ////// --}}
                            <div class="d-flex justify-content-betweet">
                                <div class="form-group col-6 p-0 pr-3">
                                    <label for="stock_quantity" class="fw-bold my-2">Số lượng</label>
                                    <input class="form-control" type="text" name="stock_quantity" id="stock_quantity"
                                        value="{{ $product->stock_quantity }}">
                                </div>
                                {{-- ////// --}}
                                <div class="form-group col-6 p-0 pl-3">
                                    <label for="product_categories" class="fw-bold my-2">Danh mục</label>
                                    <select class="form-control" id="product_categories" name="category_id">
                                        <option value="{{ $product->category_id }}">--
                                            {{ $product->product_category->category_name ?? '' }} -- (Danh mục đã chọn)
                                        </option>
                                        {!! $ShowCategories !!}

                                    </select>
                                </div>
                            </div>

                            {{-- ////// --}}
                            <div class="d-flex justify-content-betweet">
                                <div class="form-group col-6 p-0 pr-3">
                                    <label for="" class="fw-bold my-2" name="">Trạng thái</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="product_status"
                                            id="exampleRadios1" value="active"
                                            {{ $product['product_status'] == 'active' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="exampleRadios1">
                                            Còn hàng
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="product_status"
                                            id="exampleRadios2" value="inactive"
                                            {{ $product['product_status'] == 'inactive' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="exampleRadios2">
                                            Chờ duyệt
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="product_status"
                                            id="exampleRadios2" value="inactive"
                                            {{ $product['product_status'] == 'out_of_stock' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="exampleRadios2">
                                            Hết hàng
                                        </label>
                                    </div>
                                </div>
                                {{-- ////// --}}
                                <div class="form-group col-6 p-0 pl-3">
                                    <label for="" class="fw-bold my-2">Nổi bật</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="is_featured"
                                            id="examplecheckbox" value="1"
                                            {{ $product['is_featured'] == '1' ? 'checked' : '' }}>
                                        <label for="examplecheckbox">
                                            Sản phẩm nổi bật
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- ////// --}}
                        <div class="col-6">
                            <div class="form-group">
                                <label for="product_desc" class="fw-bold my-2">Mô tả sản phẩm</label>
                                <textarea name="product_desc" class="form-control" id="product_desc" cols="30" rows="5">{{ $product->product_desc }}</textarea>
                            </div>
                        </div>
                    </div>
                    {{-- ////// --}}
                    <div class="form-group">
                        <label for="product_details" class="fw-bold my-2">Chi tiết sản phẩm</label>
                        <textarea name="product_details" class="form-control" id="product_details" cols="30" rows="5">{{ $product->product_details }}</textarea>
                    </div>
                    {{-- ////////////////// --}}
                    <div class="form-group">
                        <label for="image_desc" class="fw-bold my-2">Ảnh đại diện</label>
                        <input type="file" name="image" class="form-control" id="imageInput1">
                        @error('image')
                            <small class="text-danger">{{ $message }}</small><br>
                        @enderror
                        @foreach ($product_images as $product_image)
                            @if ($product_image->pin == '1')
                                <br><img id="imagePreview1" src="{{ url($product_image->image->image_url) ?? '---' }}"
                                    alt="current image"
                                    style="max-width: 300px; height: auto; display: {{ isset($product_image->image->image_url) ? 'block' : 'none' }};">
                            @endif
                        @endforeach
                        <div class="form-group">
                            <br><img id="imagePreview1" src="" alt="Hình ảnh đại diện"
                                style="max-width: 300px; height: auto; display: none;">
                        </div>

                        <script>
                            document.getElementById('imageInput1').addEventListener('change', function(e) {
                                // Lấy file người dùng chọn
                                const file = e.target.files[0];

                                if (file) {
                                    // Tạo một URL cho file
                                    const reader = new FileReader();

                                    reader.onload = function(e) {
                                        // Hiển thị ảnh vừa chọn trong thẻ img
                                        const imagePreview = document.getElementById('imagePreview1');
                                        imagePreview.src = e.target.result;
                                        imagePreview.style.display = 'block';
                                    }

                                    reader.readAsDataURL(file);
                                }
                            });
                        </script>
                    </div>
                    {{-- //////////////////// --}}
                    <div class="form-group">
                        <label for="image_desc" class="fw-bold my-2">Gallery ảnh mô tả</label>
                        <input type="file" name="gallery[]" class="form-control" id="imageInput2" multiple>
                        @error('image')
                            <small class="text-danger">{{ $message }}</small><br>
                        @enderror
                        <br>
                        <!-- Hiển thị ảnh cũ nếu không có ảnh mới được chọn -->
                        <div id="oldImages" class="d-flex">
                            @foreach ($product_images as $product_image)
                                @if ($product_image->pin == 0 && $product_image['product_id'] == $product['product_id'])
                                    <br><img src="{{ url($product_image->image->image_url) ?? '---' }}"
                                        alt="current image" class="px-2 d-flex" style="max-width: 200px; height: auto;">
                                @endif
                            @endforeach
                        </div>
                        <div class="form-check form-switch my-3">
                            <input class="form-check-input" type="checkbox" id="mySwitch" name="delete_oldImage"
                                value="yes">
                            <label class="form-check-label" for="mySwitch">Xóa ảnh cũ</label>
                        </div>
                        <!-- Div container để hiển thị ảnh mới -->
                        <div class="form-group col-6 p-0 pr-3">
                            <br>
                            <div id="imagePreviewContainer" style="display: flex;"></div>
                        </div>
                    </div>

                    <script>
                        document.getElementById('imageInput2').addEventListener('change', function(e) {
                            // Xóa các hình ảnh cũ
                            const oldImages = document.getElementById('oldImages');
                            oldImages.style.display = 'none';

                            // Xóa các hình ảnh mới trong container trước đó
                            const imagePreviewContainer = document.getElementById('imagePreviewContainer');
                            imagePreviewContainer.innerHTML = '';

                            const files = e.target.files;

                            if (files) {
                                Array.from(files).forEach(file => {
                                    // Tạo đối tượng FileReader
                                    const reader = new FileReader();

                                    reader.onload = function(e) {
                                        // Tạo phần tử img cho từng file
                                        const img = document.createElement('img');
                                        img.src = e.target.result;
                                        img.style.maxWidth = '200px';
                                        img.style.height = 'auto';
                                        img.style.marginRight = '10px';
                                        img.style.marginBottom = '10px';

                                        // Thêm phần tử img vào container
                                        imagePreviewContainer.appendChild(img);
                                    }

                                    // Đọc file như một URL dữ liệu (base64 encoded)
                                    reader.readAsDataURL(file);
                                });
                            }
                        });
                    </script>

                    {{-- ////// --}}
                    <button type="submit" name="btn-update" class="btn btn-warning mt-2 form-control">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
@endsection
