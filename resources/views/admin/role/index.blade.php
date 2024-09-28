@extends('layouts.admin')

@section('title', 'Danh sách vai trò')

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
            <div class="card-header fw-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 mt-2 mb-2 p-0 fw-bold"><i class="fa-solid fa-list-ul"></i> Danh sách Vai trò</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div class="form-action form-inline py-3 col-3 d-flex">
                        <select class="form-control mr-1" name="act" id="">
                            <option>Chọn</option>
                            <option>Tác vụ 1</option>
                            <option>Tác vụ 2</option>
                        </select>
                        <input type="submit" name="btn-search" value="Áp dụng"
                            onclick="return confirm('Bạn có chắc thực hiện điều chỉnh này !')" class="btn btn-dark ml-3">
                    </div>
                    <div class="form-search form-inline">
                        <form action="#" class="d-flex">
                            <input type="" class="form-control form-search" name="keyword"
                                value="{{ request()->input('keyword') }}" placeholder="Tìm kiếm">
                            <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-dark">
                        </form>
                    </div>
                </div>
                <table class="table table-hover table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" class="text-center align-items-center">
                                <input name="checkall" type="checkbox">
                            </th>
                            <th scope="col" class="text-center align-items-center">STT</th>
                            <th scope="col" class="text-center align-items-center">Vai trò</th>
                            <th scope="col" class="text-center align-items-center">Mô tả</th>
                            <th scope="col" class="text-center align-items-center">Ngày tạo</th>
                            @canany(['role.edit', 'role.delete'])
                                <th scope="col" class="text-center align-items-center">Tác vụ</th>
                            @endcanany
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $t = 1;
                        @endphp
                        @forelse ($roles as $role)
                            <tr>
                                <td class="text-center align-items-center">
                                    <input type="checkbox">
                                </td>
                                <td scope="row" class="text-center align-items-center">{{ $t++ }}</td>
                                <td class="text-center align-items-center"><a
                                        href="{{ route('role.edit', $role->id) }}">{{ $role->name ?? '---' }}</a></td>
                                <td class="text-center align-items-center">{{ $role->description ?? '---' }}</td>
                                <td class="text-center align-items-center">
                                    {{ $role->created_at->format('d/m/Y H:i:s') ?? '---' }}</td>
                                @canany(['role.edit', 'role.delete'])
                                    <td class="text-center align-items-center">
                                        @can('role.edit')
                                            <a href="{{ route('role.edit', $role->id) }}"
                                                class="btn btn-success btn-sm rounded-2 text-white" type="button"
                                                data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                    class="fa fa-edit"></i></a>
                                        @endcan
                                        @can('role.delete')
                                            <a href="{{ route('role.delete', $role->id) }}"
                                                onclick="return confirm('Bạn có chắc xóa bản ghi này không ?')"
                                                class="btn btn-danger btn-sm rounded-2 text-white" type="button"
                                                data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                    class="fa fa-trash"></i></a>
                                        @endcan
                                    </td>
                                @endcanany
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" class="text-center">Không tìm thấy bản ghi nào !!!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection
