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
                <h5 class="m-0 mt-2 mb-2 fw-bold"><i class="fa-solid fa-list-ul"></i> Danh sách thành viên</h5>
                <div class="form-search form-inline">
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div class="analytic">
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'active']) }}" class="text-primary">Đã kích
                            hoạt<span class="text-muted">({{ $count[0] }})</span></a>
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'trash']) }}" class="text-primary">Vô hiệu
                            hóa<span class="text-muted">({{ $count[1] }})</span></a>
                    </div>
                    <div class="form-search form-inline col-3">
                        <form action="#" class="d-flex">
                            <input type="" class="form-control form-search" name="keyword"
                                value="{{ request()->input('keyword') }}" placeholder="Tìm kiếm">
                            <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-dark">
                        </form>
                    </div>
                </div>
                <form action="{{ url('admin/user/action') }}" method="">
                    <div class="form-action form-inline py-3 col-3 d-flex">
                        <select class="form-control mr-1" name="act" id="">
                            <option>Chọn</option>
                            @foreach ($list_act as $key => $act)
                                <option value="{{ $key }}">{{ $act }}</option>
                            @endforeach
                        </select>
                        <input type="submit" name="btn-search"
                            onclick="return confirm('Bạn có chắc thực hiện điều chỉnh này !')" value="Áp dụng"
                            class="btn btn-dark">
                    </div>
                    <table class="table table-hover table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center align-items-center">
                                    <input type="checkbox" name="checkall">
                                </th>
                                <th scope="col" class="text-center align-items-center">STT</th>
                                <th scope="col" class="text-center align-items-center">Họ Tên</th>
                                <th scope="col" class="text-center align-items-center">Email</th>
                                <th scope="col" class="text-center align-items-center">Vai trò</th>
                                <th scope="col" class="text-center align-items-center">Ngày tạo</th>
                                @canany(['user.edit', 'user.delete'])
                                    <th scope="col" class="text-center align-items-center">Tác vụ</th>
                                @endcanany
                            </tr>
                        </thead>
                        <tbody>
                            @if ($users->total() > 0)
                                @php
                                    $t = 1;
                                @endphp
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="text-center align-items-center">
                                            <input type="checkbox" name="list_check[]" value="{{ $user->id }}">
                                        </td>
                                        <td class="text-center align-items-center" scope="row">
                                            {{ $t++ }}</td>
                                        <td class="text-center align-items-center">{{ $user->fullname ?? '---' }}</td>
                                        <td class="text-center align-items-center">{{ $user->email ?? '---' }}</td>
                                        <td class="text-center align-items-center">
                                            @foreach ($user->roles as $role)
                                                <span class="badge bg-warning">{{ $role->name ?? '---' }}</span>
                                            @endforeach
                                        </td>
                                        <td class="text-center align-items-center">
                                            {{ $user->created_at->format('d/m/Y H:i:s') ?? '---' }}
                                        </td>
                                        @canany(['user.edit', 'user.delete'])
                                            <td class="text-center align-items-center">
                                                @if ($user->deleted_at != null)
                                                    @can('user.delete')
                                                        <a href="{{ route('delete_user', $user->id) }}"
                                                            onclick="return confirm('Bạn có chắc xóa bản ghi này không ?')"
                                                            class="btn btn-danger btn-sm rounded-2 text-white" type="button"
                                                            data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                                class="fa fa-trash"></i></a>
                                                    @endcan
                                                @else
                                                    @can('user.edit')
                                                        <a href="{{ route('user.edit', $user->id) }}"
                                                            class="btn btn-success btn-sm rounded-2 text-white" type="button"
                                                            data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                                class="fa fa-edit"></i></a>
                                                    @endcan
                                                    @if (Auth::id() != $user->id)
                                                        @can('user.edit')
                                                            <a href="{{ route('delete_user', $user->id) }}"
                                                                onclick="return confirm('Bạn có chắc xóa bản ghi này không ?')"
                                                                class="btn btn-danger btn-sm rounded-2 text-white" type="button"
                                                                data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                                    class="fa fa-trash"></i></a>
                                                        @endcan
                                                    @endif
                                                @endif
                                            </td>
                                        @endcanany
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8" class="text-center">Không có bản ghi nào !!!</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </form>
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection
