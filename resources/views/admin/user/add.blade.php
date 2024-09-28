@extends('layouts.admin') 

@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header fw-bold">
        <h5 class="m-0 mt-2 mb-2 p-0 fw-bold"><i class="fa-solid fa-folder-plus"></i> thêm thành viên</h5>
        </div>
        <div class="card-body">
            <form action="{{url('admin/user/store')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name" class="fw-bold my-2">họ và tên</label>
                    <input class="form-control" type="text" name="fullname" id="name">
                    @error('fullname')
                       <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="name" class="fw-bold my-2">tên tài khoản</label>
                    <input class="form-control" type="text" name="name" id="name">
                    @error('name')
                       <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email" class="fw-bold my-2">Email</label>
                    <input class="form-control" type="text" name="email" id="email">
                    @error('email')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password" class="fw-bold my-2">Mật khẩu</label>
                    <input class="form-control" type="password" name="password" id="password">
                    @error('password')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                {{-- <div class="form-group">
                    <label for="password-confirm">Xác nhận mật khẩu</label>
                    <input class="form-control" type="password" name="password_confirm" id="password-confirm">
                </div> --}}

                <div class="form-group">
                    {{-- <label for="" class="fw-bold my-2">Nhóm quyền</label> --}}
                    {{ Form::label('roles', 'roles', ['class' => 'fw-bold my-2']) }}
                    @php
                    $selectedRoles = $roles->pluck('id')->toArray();
                    $options = $roles->pluck('name', 'id')->toArray();
                    @endphp
                    {{Form::select('roles[]', $options, $selectedRoles, ['id' => 'roles', 'class' => 'form-control', 'multiple' => true])}}
                     {{-- <select class="form-control" id="">
                            <option>Chọn quyền</option>
                            <option>Danh mục 1</option>
                        </select> --}}
                </div>

                <button type="submit" name="btn-add" class="btn btn-warning mt-3 form-control">Thêm mới</button>
            </form>
        </div>
    </div>
</div>
@endsection 