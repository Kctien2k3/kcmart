@extends('layouts.admin')

@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
               <h5 class="m-0 mt-2 mb-2 p-0 font-weight-bold"><i class="fa-solid fa-pen-to-square"></i> Chỉnh sửa chi tiết Menu</h5>
            </div>
            <div class="card-body">
                <form action="{{route('menu.update', $menu->menu_id)}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="menu_title" class="font-weight-bold">Tiêu đề Menu</label>
                        <input class="form-control" type="text" name="menu_title" id="menu_title" value="{{$menu->menu_title}}">
                        @error('menu_title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="menu_url" class="font-weight-bold">Menu Link</label>
                        <input class="form-control" type="text" name="menu_url" id="menu_url" value="{{$menu->menu_url}}">
                        @error('menu_url')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    {{-- <div class="form-group">
                       
                        <label for="content" class="font-weight-bold">Nội dung Trang</label>
                        <textarea name="page_content" class="form-control" id="content" cols="30" rows="5"></textarea>
                        @error('page_content')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror

                    </div> --}}


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
                        <label for="status" class="font-weight-bold">Trạng thái</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="menu_status" id="status"
                            {{ $menu->menu_status == 'draft' ? 'checked' : '' }} value="draft">
                            <label class="form-check-label" for="status">
                                Chờ duyệt
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="menu_status" id="status"
                            {{ $menu->menu_status == 'published' ? 'checked' : '' }} value="published">
                            <label class="form-check-label" for="status">
                                Công khai
                            </label>
                        </div>
                        @error('menu_status')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <button type="submit" name="btn-add" class="btn btn-primary">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
@endsection
