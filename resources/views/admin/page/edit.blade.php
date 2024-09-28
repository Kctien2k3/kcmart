@extends('layouts.admin')

@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header fw-bold">
            <h5 class="m-0 mt-2 mb-2 p-0 fw-bold"><i class="fa-solid fa-pen-to-square"></i> Chỉnh sửa chi tiết Trang</h5>
            </div>
            <div class="card-body">
                <form action="{{route('page.update', $page->page_id)}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="fw-bold my-2">Tiêu đề Trang</label>
                        <input class="form-control" type="text" name="page_title" value="{{$page->page_title}}" id="name">
                        @error('page_title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name" class="fw-bold my-2">Slug Trang</label>
                        <input class="form-control" type="text" name="page_slug" value="{{$page->page_slug}}" id="name">
                        @error('page_slug')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="content" class="fw-bold my-2">Nội dung Trang</label>
                        <textarea name="page_content" class="form-control" id="page_content" cols="30" rows="5" >{{$page->page_content}}</textarea>
                        @error('page_content')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror

                    </div>


                    {{-- <div class="form-group">
                    <label for="">Danh mục</label>
                    <select class="form-control" id="">
                        <option>Chọn danh mục</option>
                        <option>Danh mục 1</option>
                        <option>Danh mục 2</option>
                        <option>Danh mục 3</option>
                        <option>Danh mục 4</option>
                    </select>
                </div> --}}
                    <div class="form-group">
                        <label for="status" class="fw-bold my-2">Trạng thái</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="page_status" id="status"
                            {{ $page->page_status == 'draft' ? 'checked' : '' }} value="draft">
                            <label class="form-check-label" for="status">
                                Chờ duyệt
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="page_status" id="status"
                            {{ $page->page_status == 'published' ? 'checked' : '' }} value="published">
                            <label class="form-check-label" for="status">
                                Công khai
                            </label>
                        </div>
                        @error('page_status')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <button type="submit" name="btn-update" class="btn btn-warning mt-3 form-control">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
@endsection
