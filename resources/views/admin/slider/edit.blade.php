@extends('layouts.admin');

@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header fw-bold">
                <h5 class="m-0 mt-2 mb-2 p-0 fw-bold"><i class="fa-solid fa-pen-to-square"></i> Chỉnh sửa chi tiết
                    slider</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('slider.update', $slider->slider_id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="title" class="fw-bold my-2">Tiêu đề slider</label>
                        <input class="form-control" type="text" name="slider_title" id="title"
                            value="{{ $slider->slider_title }}">
                        @error('slider_title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="image_id" class="fw-bold my-2">Upload file/Ảnh</label>
                        <input type="file" name="image" id="imageInput" class="form-control">
                        @error('image')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <div class="form-group col-6 p-0 pr-3">
                            <br>
                            <img id="imagePreview" src="{{ url($slider->image->image_url) ?? '---' }}" alt="current image"
                                style="max-width: 300px; height: auto; display: {{ isset($slider->image->image_url) ? 'block' : 'none' }};">
                        </div>
                        <script>
                            document.getElementById('imageInput').addEventListener('change', function(e) {
                                // Lấy file người dùng chọn
                                const file = e.target.files[0];
                                if (file) {
                                    // Tạo một URL cho file
                                    const reader = new FileReader();
                                    reader.onload = function(e) {
                                        // Hiển thị ảnh vừa chọn trong thẻ img
                                        const imagePreview = document.getElementById('imagePreview');
                                        imagePreview.src = e.target.result;
                                        imagePreview.style.display = 'block';
                                    }
                                    reader.readAsDataURL(file);
                                }
                            });
                        </script>
                    </div>
                    <div class="form-group">
                        <label for="disc" class="fw-bold my-2">Mô tả ngắn</label>
                        <textarea name="slider_desc" class="form-control" id="disc" cols="30" rows="5">{{ $slider->slider_desc }}</textarea>
                        @error('slider_desc')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="slider_url" class="fw-bold my-2">Link</label>
                        <input class="form-control" type="text" name="slider_url" id="slider_url"
                            value="{{ $slider->slider_url }}">
                        @error('slider_url')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="" class="fw-bold my-2">Trạng thái</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="slider_status" id="exampleRadios1"
                                value="draft" {{ $slider['slider_status'] == 'draft' ? 'checked' : '' }}>
                            <label class="form-check-label" for="slider_status">
                                Chờ duyệt
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="slider_status" id="exampleRadios2"
                                value="published" {{ $slider['slider_status'] == 'published' ? 'checked' : '' }}>
                            <label class="form-check-label" for="slider_status">
                                Công khai
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-warning mt-3 form-control">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
@endsection
