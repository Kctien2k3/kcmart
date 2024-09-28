@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header fw-bold">
                <h5 class="m-0 mt-2 mb-2 p-0 fw-bold"><i class="fa-solid fa-folder-plus"></i> thêm sản phẩm</h5>
            </div>
            <div class="card-body">
                <form action="{{ url('admin/product/store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            {{-- ////// --}}
                            <div class="form-group">
                                <label for="product_title" class="fw-bold my-2">Tên sản phẩm</label>
                                <input class="form-control" type="text" name="product_title" id="product_title" old="">
                                @error('product_title')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            {{-- //////// --}}
                            <div class="form-group">
                                <label for="product_slug" class="fw-bold my-2">Slug</label>
                                <input class="form-control" type="text" name="product_slug" id="product_slug">
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

                                {{-- //////// --}}
                                <div class="form-group col-6 p-0 pr-3">
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
                                    <input class="form-control" type="text" name="stock_quantity" id="stock_quantity">
                                </div>
                                {{-- ////// --}}
                                <div class="form-group col-6 p-0 pl-3">
                                    <label for="product_categories" class="fw-bold my-2">Danh mục</label>
                                    <select class="form-control" name="category_id" id="">
                                        <option>Chọn danh mục sản phẩm</option>
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
                                            id="exampleRadios1" value="active" checked>
                                        <label class="form-check-label" for="exampleRadios1">
                                            Còn hàng
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="product_status"
                                            id="exampleRadios2" value="inactive">
                                        <label class="form-check-label" for="exampleRadios2">
                                            Chờ duyệt
                                        </label>
                                    </div>
                                </div>
                                {{-- ////// --}}
                                <div class="form-group col-6 p-0 pl-3">
                                    <label for="" class="fw-bold my-2">Nổi bật</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="is_featured"
                                            id="examplecheckbox" value="1">
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
                                <textarea name="product_desc" class="form-control" id="product_desc" cols="30" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                    {{-- ////// --}}
                    <div class="form-group">
                        <label for="product_details" class="fw-bold my-2">Chi tiết sản phẩm</label>
                        <textarea name="product_details" class="form-control" id="product_details" cols="30" rows="5"></textarea>
                    </div>


                    {{-- /////////////////////////////// --}}
                    <div class="form-group">
                        <label for="image_desc" class="fw-bold my-2">Ảnh đại diện</label>
                        <input type="file" name="image" class="form-control" id="imageInput1">

                        @error('image')
                            <small class="text-danger">{{ $message }}</small><br>
                        @enderror
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
                        <div class="form-group">
                            <label for="image_desc" class="fw-bold my-2">Gallery ảnh mô tả</label>
                            <input type="file" name="gallery[]" multiple class="form-control" id="imageInput">
                            @error('gallery')
                                <small class="text-danger">{{ $message }}</small><br>
                            @enderror
                            <!-- Div container to display selected images -->
                            <div class="form-group col-6 p-0 pr-3">
                                <br>
                                <div id="imagePreviewContainer" style="display: flex;"></div>
                            </div>
                        </div>
                    </div>

                    <script>
                        document.getElementById('imageInput').addEventListener('change', function(e) {
                            // Clear the container before displaying new images
                            const imagePreviewContainer = document.getElementById('imagePreviewContainer');
                            imagePreviewContainer.innerHTML = '';

                            const files = e.target.files;

                            if (files) {
                                Array.from(files).forEach(file => {
                                    // Create a FileReader object
                                    const reader = new FileReader();

                                    reader.onload = function(e) {
                                        // Create an img element for each file
                                        const img = document.createElement('img');
                                        img.src = e.target.result;
                                        img.style.maxWidth = '200px';
                                        img.style.height = 'auto';
                                        img.style.marginRight = '10px';
                                        img.style.marginBottom = '10px';

                                        // Append the img element to the container
                                        imagePreviewContainer.appendChild(img);
                                    }

                                    // Read the file as a Data URL (base64 encoded)
                                    reader.readAsDataURL(file);
                                });
                            }
                        });
                    </script>

                    {{-- ////// --}}
                    <br><button type="submit" name="btn-add" class="btn btn-warning mt-3 form-control">Thêm mới</button>
                </form>
            </div>
        </div>
    </div>
@endsection

{{-- <div class="form-group">
    <label for="image_desc" class="fw-bold my-2">Upload File/Ảnh</label>
    <div class="d-flex input-group control-group ist increment">
        <input type="file" name="image[]" class="form-control" multiple>
        <div class="input-group-btn">
            <button class="btn btn-success" id="addfile" type="button">+</button>
        </div>
    </div>
    <div class="clone" id="morefile" style="display: none">
        <div class="control-group input-group" style="margin-top: 10px">
            <input type="file" name="image[]" class="my-frm form-control">
            <div class="input-group-btn">
                <button class="btn btn-danger" id="removefile" type="button"> - </button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#addfile").click(function() {
            var html = $(".clone").html();
            $(".increment").after(html);
        });

        // Corrected the typo here
        $("body").on("click", "#removefile", function() {
            $(this).parents(".control-group").remove();
        });
    });
</script> --}}
