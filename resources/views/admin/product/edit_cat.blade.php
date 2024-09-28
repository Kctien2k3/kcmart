@extends('layouts.admin')

@section('content')
    <style>
        .card {
            box-shadow: 0 12px 15px rgba(0, 0, 0, 0.3);
        }

        tbody>tr {
            transition: transform 0.5s ease, background-color 0.5s ease, box-shadow 0.5s ease;
        }

        tbody>tr:hover {
            transform: scale(1.002);
            box-shadow: 0 3px 5px rgba(0, 0, 0, 0.3);

        }
    </style>
    <div id="content" class="container-fluid">
        <div class="row">
            <div class="col-4">
                <div class="card">
                    <div class="card-header fw-bold">
                        <h5 class="m-0 mt-2 mb-2 p-0 fw-bold"><i class="fa-solid fa-pen-to-square"></i> Chỉnh sửa
                            danh mục sản phẩm</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('category.update', $category->category_id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name" class="fw-bold my-2">Tên danh mục</label>
                                <input class="form-control" type="text" name="category_name" id="name"
                                    value="{{ $category->category_name }}">
                                @error('category_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name" class="fw-bold my-2">Đường dẫn danh mục</label>
                                <input class="form-control" type="text" name="category_slug" id="name"
                                    value="{{ $category->category_slug }}">
                                @error('category_slug')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="" class="fw-bold my-2">Danh mục cha</label>
                                <select class="form-control" name="parent_id" id="">
                                    <option value="0">Danh mục đầu</option>
                                    <option value="{{$category->parent_id}}" selected>-- {{$category->parent->category_name ?? ''}} -- (Danh mục đã chọn)</option>
                                    @php
                                //    $selected_id = 5;
                                    function ShowCategories($categories, $parent_id = 0, $char = '')
                                    {
                                        foreach ($categories as $key => $item) {
                                            // Kiểm tra nếu là danh mục con
                                            if ($item->parent_id == $parent_id) {
                                                echo '<option value="' . $item->category_id . '" >' . 
                                                    $char . $item->category_name . 
                                                    '</option>';
                                                
                                                // Đệ quy để hiển thị danh mục con
                                                ShowCategories($categories, $item->category_id, $char . ' -- ');
                                            }
                                        }
                                    }
                                @endphp
                                
                                @php
                                    ShowCategories($categories);
                                @endphp
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="" class="fw-bold my-2">Trạng thái</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="category_status"
                                        {{ $category->category_status == 'draft' ? 'checked' : '' }} id="exampleRadios1"
                                        value="draft">
                                    <label class="form-check-label" for="exampleRadios1">
                                        Chờ duyệt
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="category_status"
                                        {{ $category->category_status == 'published' ? 'checked' : '' }} id="exampleRadios2"
                                        value="published">
                                    <label class="form-check-label" for="exampleRadios2">
                                        Công khai
                                    </label>
                                </div>
                                @error('category_status')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <button type="submit" name="btn-add" class="btn btn-warning mt-3 form-control">Cập
                                nhật</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card">
                    @if (session('status_success'))
                        <div class="alert alert-success">
                            {{ session('status_success') }}
                        </div>
                    @elseif (session('status_danger'))
                        <div class="alert alert-danger">
                            {{ session('status_danger') }}
                        </div>
                    @endif
                    <div class="card-header fw-bold">
                        <h5 class="m-0 mt-2 mb-2 p-0 fw-bold"><i class="fa-solid fa-bars-staggered"></i> danh mục
                            sản phẩm</h5>
                    </div>
                    {{-- <form action="{{ url('admin/product/cat/delele_cat') }}"> --}}
                    <div class="card-body">
                        <table class="table table-hover table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col" class="text-center">STT</th>
                                    <th scope="col">Tên danh mục</th>
                                    <th scope="col" class="text-center">Trạng thái</th>
                                    <th scope="col" class="text-center">Người tạo</th>
                                    <th scope="col" class="text-center">Ngày tạo</th>
                                    <th scope="col" class="text-center">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                {!! $TableCategories !!}
                            </tbody>
                        </table>
                    </div>
                    {{-- </form> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
