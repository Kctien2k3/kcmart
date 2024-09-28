@extends('layouts.admin')

@section('title', 'Tạo mới quyền')

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
            @if (session('status_success'))
                <div class="alert alert-success">
                    {{ session('status_success') }}
                </div>
            @elseif (session('status_danger'))
                <div class="alert alert-danger">
                    {{ session('status_danger') }}
                </div>
            @endif
            <div class="col-4">
                <div class="card">
                    <div class="card-header fw-bold">
                        <h5 class="m-0 mt-2 mb-2 p-0 fw-bold"><i class="fa-solid fa-pen-to-square"></i> Chỉnh sửa chi tiết quyền</h5>
                    </div>
                    <div class="card-body">
                        {{-- <form> --}}
                        {!! Form::open(['route' => ['permission.update', $permission->id], 'method' => 'POST']) !!}
                        <div class="form-group">
                            {{-- <label for="name">Tên quyền</label>
                                <input class="form-control" type="text" name="name" id="name"> --}}
                            {{ Form::label('name', 'Tên quyền', ['class' => 'fw-bold my-2']) }}
                            {{ Form::text('name', $permission->name, ['class' => 'form-control', 'id' => 'name']) }}
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            {{-- <label for="slug">Slug</label>
                                <small class="form-text text-muted pb-2">Ví dụ: posts.add</small>
                                <input class="form-control" type="text" name="slug" id="slug"> --}}
                            {{ Form::label('slug', 'Slug', ['class' => 'fw-bold my-2']) }}<br>
                            <small class="form-text text-muted pb-2">Ví dụ: posts.add</small>
                            {{ Form::text('slug', $permission->slug, ['class' => 'form-control', 'id' => 'slug']) }}

                        </div>
                        <div class="form-group">
                            {{-- <label for="description">Mô tả</label>
                                <textarea class="form-control" type="text" name="description" id="description"> </textarea> --}}
                            {{ Form::label('description', 'Mô tả', ['class' => 'fw-bold my-2']) }}
                            {{ Form::textarea('description', $permission->description, ['class' => 'form-control', 'id' => 'description', 'rows' => 3]) }}
                        </div>
                        <button type="submit" class="btn btn-warning mt-3 form-control">Cập nhật</button>
                        {{-- </form> --}}
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card">
                    <div class="card-header fw-bold">
                        <h5 class="m-0 mt-2 mb-2 p-0 fw-bold"><i class="fa-solid fa-bars-staggered"></i> danh sách quyền
                        </h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col" class="text-center">STT</th>
                                    <th scope="col">Tên quyền</th>
                                    <th scope="col" class="text-center">Slug</th>
                                    @canany(['permission.edit', 'permission.delete'])
                                    <th scope="col" class="text-center">Tác vụ</th>
                                @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $t = 1;
                                @endphp
                                @foreach ($permissions as $moduleName => $modulePermission)
                                    <tr class="table-secondary">
                                        <td scope="row"></td>
                                        <td colspan=""><strong>Module {{ ucfirst($moduleName) }}</strong></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    @foreach ($modulePermission as $permission)
                                        <tr>
                                            <td scope="row" class="text-center align-items-center">{{ $t++ }}
                                            </td>
                                            <td>|--- {{ $permission->name ?? '---' }}</td>
                                            <td class="text-center align-items-center">{{ $permission->slug ?? '---' }}
                                            </td>
                                            @canany(['permission.edit', 'permission.delete'])
                                                <td class="text-center align-items-center">
                                                    @can('permission.edit')
                                                        <a href="{{ route('permission.edit', $permission->id) }}"
                                                            class="btn btn-success btn-sm rounded-2 text-white" type="button"
                                                            data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                                class="fa fa-edit"></i></a>
                                                    @endcan
                                                    @can('permission.delete')
                                                        <a href="{{ route('permission.delete', $permission->id) }}"
                                                            onclick="return confirm('Bạn có chắc xóa bản ghi này không ?')"
                                                            class="btn btn-danger btn-sm rounded-2 text-white" type="button"
                                                            data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                                class="fa fa-trash"></i></a>
                                                    @endcan
                                                </td>
                                            @endcanany
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
