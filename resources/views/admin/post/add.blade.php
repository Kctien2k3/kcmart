@extends('layouts.admin')

@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header fw-bold">
            <h5 class="m-0 mt-2 mb-2 p-0 fw-bold"><i class="fa-solid fa-folder-plus"></i> thêm bài viết</h5>
            </div>
            <div class="card-body">
                <form action="{{url('admin/post/store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="post_title" class="fw-bold my-2">Tiêu đề bài viết</label>  
                        <input class="form-control" type="text" name="post_title" id="post_title">
                        @error('post_title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div> 
                    <div class="form-group">
                        <label for="post_slug" class="fw-bold my-2">Slug bài viết</label>  
                        <input class="form-control" type="text" name="post_slug" id="post_slug">
                        @error('post_slug')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="desc">
                        <label for="desc" class="fw-bold my-2">Mô tả ngắn</label>
                        <textarea name="post_excerpt" class="form-control" id="desc" cols="30" rows="5"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="content" class="fw-bold my-2">Nội dung bài viết</label>
                        <textarea name="post_content" class="form-control" id="content" cols="30" rows="10"></textarea>
                        @error('post_content')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="" class="fw-bold my-2">Danh mục</label>
                        <select class="form-control" name="category_id" id="">
                            <option>Chọn danh mục bài viết</option>
                            {!! $categories !!}                    
                        </select>
                        @error('category_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    {{-- upload file/ảnh  --}}
                    <div class="form-group">
                        <label for="image_id" class="fw-bold my-2">Upload file/Ảnh</label>
                        {{-- {!! Form::file('image', ['class'=>'form-control']) !!}  --}}
                        <input type="file" name="image" id="imageInput" class="form-control">
                        @error('image')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <div class="form-group col-6 p-0 pr-3">
                            <br><img id="imagePreview" src="" alt="Hình ảnh đại diện" style="max-width: 300px; height: auto; display: none;">
                        </div>
                        
                        <script>
                            document.getElementById('imageInput').addEventListener('change', function (e) {
                                // Lấy file người dùng chọn
                                const file = e.target.files[0];
                                
                                if (file) {
                                    // Tạo một URL cho file
                                    const reader = new FileReader();
                        
                                    reader.onload = function (e) {
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
                        <label for="" class="font-w eight-bold">Trạng thái</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="post_status" id="exampleRadios1"
                                value="draft">
                            <label class="form-check-label" for="exampleRadios1">
                                Chờ duyệt
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="post_status" id="exampleRadios2"
                                value="published">
                            <label class="form-check-label" for="exampleRadios2">
                                Công khai
                            </label>
                        </div>
                        @error('post_status')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <button type="submit" name="btn-add" class="btn btn-warning mt-3 form-control">Thêm mới</button>
                </form>
            </div>
        </div>
    </div>
@endsection
