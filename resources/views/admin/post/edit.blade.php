@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header fw-bold">
                <h5 class="m-0 mt-2 mb-2 p-0 fw-bold"><i class="fa-solid fa-pen-to-square"></i> Chỉnh sửa chi tiết
                    bài viết</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('post.update', $post->post_id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{-- ////// --}}
                    <div class="form-group">
                        <label for="name" class="fw-bold my-2">Tiêu đề bài viết</label>
                        <input class="form-control" type="text" name="post_title" id="name"
                            value="{{ $post->post_title }}">
                        @error('post_title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    {{-- ////// --}}
                    <div class="form-group">
                        <label for="name" class="fw-bold my-2">slug bài viết</label>
                        <input class="form-control" type="text" name="post_slug" id="name"
                            value="{{ $post->post_slug }}">
                        @error('post_slug')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    {{-- ////// --}}
                    <div class="form-group">
                        <br><label for="content" class="fw-bold my-2">Mô tả ngắn</label>
                        <textarea name="post_excerpt" class="form-control" id="content" cols="30" rows="5">{{ $post->post_excerpt }}</textarea>
                        @error('post_excerpt')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    {{-- ////// --}}
                    <div class="form-group">
                        <label for="content" class="fw-bold my-2">Nội dung bài viết</label>
                        <textarea name="post_content" class="form-control" id="content" cols="30" rows="10">{{ $post->post_content }}</textarea>
                        @error('post_content')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    {{-- ////// --}}
                    <div class="form-group">
                        <label for="" class="fw-bold my-2">Danh mục</label>
                        <select class="form-control" name="category_id" id="">
                            <option value="{{$post->category_id}}">-- {{$post->post_category->category_name ?? ''}} -- (Danh mục đã chọn)</option>
                            {!! $ShowCategories !!}
                        </select>
                        @error('category_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    {{-- upload file/ảnh  --}}
                    <div class="form-group">
                        <label for="image_id" class="fw-bold my-2">Upload file/Ảnh</label>
                        <!-- {!! Form::file('image', ['class' => 'form-control']) !!}  -->
                        <input type="file" name="image" class="form-control" id="imageInput">
                        @error('image')
                            <small class="text-danger">{{ $message }}</small><br>
                        @enderror
                        <div class="form-group col-6 p-0 pr-3">
                            <br>
                            <img id="imagePreview" src="{{ url($post->image->image_url) ?? '---' }}" alt="current image"
                                style="max-width: 300px; height: auto; display: {{ isset($post->image->image_url) ? 'block' : 'none' }};">
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
                    {{-- ////// --}}
                    <div class="form-group">
                        <label for="" class="fw-bold my-2">Trạng thái</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="post_status" id="exampleRadios1"
                                {{ $post->post_status == 'draft' ? 'checked' : '' }} value="draft">
                            <label class="form-check-label" for="exampleRadios1">
                                Chờ duyệt
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="post_status" id="exampleRadios2"
                                {{ $post->post_status == 'published' ? 'checked' : '' }} value="published">
                            <label class="form-check-label" for="exampleRadios2">
                                Công khai
                            </label>
                        </div>
                        @error('post_status')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    {{-- ////// --}}

                    <button type="submit" name="btn-update" class="btn btn-warning mt-3 form-control">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
@endsection
