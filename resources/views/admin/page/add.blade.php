@extends('layouts.admin')

@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header fw-bold">
            <h5 class="m-0 mt-2 mb-2 p-0 fw-bold"><i class="fa-solid fa-folder-plus"></i> thêm Trang</h5>
        </div>
        <div class="card-body">
            <form action="{{url('admin/page/store')}}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="page_title" class="fw-bold my-2">Tiêu đề Trang <span class="text-danger">*</span></label>
                    <input class="form-control" type="text" name="page_title" id="page_title">
                    @error('page_title')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="page_slug" class="fw-bold my-2">Slug Trang  <span class="text-danger">*</span></label>
                    <input class="form-control" type="text" name="page_slug" id="page_slug">
                    @error('page_slug')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group mb-3">

                    <label for="content" class="fw-bold my-2">Nội dung Trang  <span class="text-danger">*</span></label>
                    <textarea name="page_content" class="form-control" id="content" cols="30" rows="5"></textarea>
                    @error('page_content')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror

                </div>
                <!-- <div class="form-group">
                    <label for="" class="fw-bold my-2">Danh mục</label>
                    <select class="form-control" id="">
                        <option>Chọn danh mục</option>
                        <option>Danh mục 1</option>
                        <option>Danh mục 2</option>
                        <option>Danh mục 3</option>
                        <option>Danh mục 4</option>
                    </select>
                    {{-- @error('page_category')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror --}}
                </div> -->
                <div class="form-group mb-3">
                    <label for="status" class="fw-bold my-2">Trạng thái  <span class="text-danger">*</span></label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="page_status" id="status" value="draft">
                        <label class="form-check-label" for="status">
                            Chờ duyệt
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="page_status" id="status" value="published">
                        <label class="form-check-label" for="status">
                            Công khai
                        </label>
                    </div>
                    @error('page_status')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <button type="submit" name="btn-add" class="btn btn-warning mt-3 form-control">Thêm mới</button>
            </form>
        </div>
    </div>
</div>
@endsection