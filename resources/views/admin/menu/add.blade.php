@extends('layouts.admin')

@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
            <h5 class="m-0 mt-2 mb-2 p-0 font-weight-bold"><i class="fa-solid fa-folder-plus"></i> thêm menu</h5>
            </div>
            <div class="card-body">
                <form action="{{url('admin/menu/store')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="menu_title" class="font-weight-bold">Tiêu đề Menu</label>
                        <input class="form-control" type="text" name="menu_title" id="menu_title">
                        @error('menu_title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="menu_url" class="font-weight-bold">Menu Link</label>
                        <input class="form-control" type="text" name="menu_url" id="menu_url">
                        @error('menu_url')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="status" class="font-weight-bold">Trạng thái</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="menu_status" id="status"
                                value="draft">
                            <label class="form-check-label" for="status">
                                Chờ duyệt
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="menu_status" id="status"
                                value="published">
                            <label class="form-check-label" for="status">
                                Công khai
                            </label>
                        </div>
                        @error('menu_status')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <button type="submit" name="btn-add" class="btn btn-primary">Thêm mới</button>
                </form>
            </div>
        </div>
    </div>
@endsection
