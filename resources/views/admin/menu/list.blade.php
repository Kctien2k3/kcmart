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
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 mt-2 mb-2 p-0 font-weight-bold"><i class="fa-solid fa-list-ul"></i> Danh sách Menu</h5>

            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div class="analytic">
                        <a href="{{ request()->fullUrlWithQuery(['menu_status' => 'all']) }}" class="text-primary">Tất
                            cả<span class="text-muted"> ({{ $count[0] }})</span></a>
                        <a href="{{ request()->fullUrlWithQuery(['menu_status' => 'published']) }}" class="text-primary">Đã
                            đăng<span class="text-muted"> ({{ $count[1] }})</span></a>
                        <a href="{{ request()->fullUrlWithQuery(['menu_status' => 'draft']) }}" class="text-primary">Chờ
                            duyệt<span class="text-muted"> ({{ $count[2] }})</span></a>
                    </div>
                    <div class="form-search form-inline col-3">
                        <form action="#" class="d-flex">
                            <input type="text" class="form-control form-search" name="keyword" placeholder="Tìm kiếm"
                                value="{{ request()->input('keyword') }}">
                            <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-dark">
                        </form>
                    </div>
                </div>
                <div class="form-action form-inline py-3">
                    {{-- <select class="form-control mr-1" id="">
                        <option>Chọn</option>
                        <option>Tác vụ 1</option>
                        <option>Tác vụ 2</option>
                    </select>
                    <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary"> --}}
                </div>
                <table class="table table-hover table-bordered">
                    <thead class="table-dark">
                        <tr>
                            {{-- <th scope="col">
                                <input name="checkall" type="checkbox">
                            </th> --}}
                            <th scope="col" class="text-center align-items-center">#</th>
                            <th scope="col" class="text-center align-items-center">Tên menu</th>
                            <th scope="col" class="text-center align-items-center">Link</th>
                            <th scope="col" class="text-center align-items-center">Trạng thái</th>
                            <th scope="col" class="text-center align-items-center">Người tạo</th>
                            <th scope="col" class="text-center align-items-center">Ngày tạo</th>
                            <th scope="col" class="text-center align-items-center">Ngày cập nhật</th>
                            <th scope="col" class="text-center align-items-center">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if ($menu != null && $menu->total() > 0)
                            @php
                                $t = 0;
                            @endphp
                            @foreach ($menu as $item)
                                @php
                                    $t++;
                                @endphp
                                <tr>
                                    {{-- <td>
                                        <input type="checkbox">
                                    </td> --}}
                                    <td scope="row" class="text-center align-items-center font-weight-bold">
                                        {{ $t }}</td>
                                    <td class="text-center align-items-center">{{ $item->menu_title }}</td>
                                    <td class="text-center align-items-center"><a href="">{{ $item->menu_url }}</a>
                                    </td>
                                    <td class="text-center align-items-center">
                                        @if ($item->menu_status == 'draft')
                                            <span class="badge bg-warning">{{ $item->menu_status }}</span>
                                        @elseif ($item->menu_status == 'published')
                                            <span class="badge bg-success">{{ $item->menu_status }}</span>
                                        @endif
                                    </td>
                                    <td class="text-center align-items-center">{{ $item->creator }}</td>
                                    <td class="text-center align-items-center">{{ $item->created_at }}</td>
                                    <td class="text-center align-items-center">{{ $item->updated_at }}</td>
                                    <td class="text-center align-items-center"><a
                                            href="{{ route('menu.edit', $item->menu_id) }}"
                                            class="btn btn-success btn-sm rounded-2 text-white" type="button" data-toggle="tooltip"
                                            data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                        <a href="{{ route('delete_menu', $item->menu_id) }}"
                                            class="btn btn-danger btn-sm rounded-2 text-white" type="button" data-toggle="tooltip"
                                            data-placement="top"
                                            onclick="return confirm('Bạn có chắc xóa bản ghi này không ?')"
                                            title="Delete"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            {
                            <tr>
                                <td colspan="12" class="text-center">Không tìm thấy bản ghi nào !!!</td>
                            </tr>
                            }
                        @endif
                    </tbody>
                </table>
                {{ $menu->links() }}
            </div>
        </div>
    </div>
@endsection
