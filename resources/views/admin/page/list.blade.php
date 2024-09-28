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
                <h5 class="m-0 mt-2 mb-2 p-0 fw-bold"><i class="fa-solid fa-list-ul"></i> Danh sách Trang</h5>
                <div class="form-search form-inline">
                    {{-- <a href="" class="btn btn-primary">Thêm mới</a> --}}
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div class="analytic">
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'all']) }}" class="text-primary">Tất cả<span
                                class="text-muted">({{ $count[0] }})</span></a>
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'published']) }}" class="text-primary">Đã
                            đăng<span class="text-muted">({{ $count[3] }})</span></a>
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'draft']) }}" class="text-primary">Chờ
                            duyệt<span class="text-muted">({{ $count[1] }})</span></a>
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'trash']) }}" class="text-primary">Thùng
                            rác<span class="text-muted">({{ $count[2] }})</span></a>
                    </div>
                    <div class="form-search form-inline col-3">
                        <form action="#" class="d-flex">
                            <input type="" class="form-control form-search" name="keyword"
                                value="{{ request()->input('keyword') }}" placeholder="Tìm kiếm">
                            <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-dark">
                        </form>
                    </div>
                </div>
                <form action="{{ url('admin/page/action') }}" method="">
                    <div class="form-action form-inline py-3 col-3 d-flex">
                        <select class="form-control mr-1" name="act" id="">
                            <option>Chọn</option>
                            @foreach ($list_act as $key => $act)
                                <option value="{{ $key }}">{{ $act }}</option>
                            @endforeach
                        </select>
                        <input type="submit" name="btn-search" value="Áp dụng"
                            onclick="return confirm('Bạn có chắc thực hiện điều chỉnh này !')" class="btn btn-dark ml-3">
                    </div>
                    <table class="table table-hover table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" class="text-center align-items-center">
                                    <input name="checkall" type="checkbox">
                                </th>
                                <th scope="col" class="text-center align-items-center">STT</th>
                                <th scope="col" class="text-center align-items-center">Tiêu đề</th>
                                <th scope="col" class="text-center align-items-center">Người tạo</th>
                                <th scope="col" class="text-center align-items-center">Trạng thái</th>
                                <th scope="col" class="text-center align-items-center">Ngày tạo</th>
                                <th scope="col" class="text-center align-items-center">Ngày cập nhật gần nhất</th>
                                @canany (['page.edit', 'page.delete'])
                                <th scope="col" class="text-center align-items-center">Tác vụ</th>
                                @endcanany
                            </tr>
                        </thead>
                        <tbody>
                            @if ($pages !== null && $pages->total() > 0)
                                @php
                                    $t = 1;
                                @endphp
                                @foreach ($pages as $page)
                                    <tr>
                                        <td class="text-center align-items-center">
                                            <input type="checkbox" name="list_check[]" value="{{ $page->page_id }}">
                                        </td>
                                        <td scope="row" class="text-center align-items-center">{{ $t++ }}</td>
                                        <td class="text-center align-items-center"><a class="text-dark"
                                                href="">{{ $page->page_title }}</a></td>
                                        <td class="text-center align-items-center">{{ Auth::user()->name ?? '---' }}</td>
                                        <td class="text-center align-items-center">
                                            @if ($page->page_status == 'draft')
                                                <span class="badge bg-warning">Chờ duyệt</span>
                                            @elseif ($page->page_status == 'published')
                                                <span class="badge bg-success">Công khai</span>
                                            @endif
                                        </td>
                                        <td class="text-center align-items-center">
                                            {{ $page->created_at->format('d/m/Y') ?? '---' }}
                                        </td>
                                        <td class="text-center align-items-center">
                                            {{ $page->updated_at->format('d/m/Y H:i:s') ?? '---' }}
                                        </td>
                                        @canany(['page.edit', 'page.delete'])
                                            <td class="text-center align-items-center">
                                                @if ($page->deleted_at != null)
                                                    @can('page.delete')
                                                        <a href="{{ route('delete_page', $page->page_id) }}"
                                                            onclick="return confirm('Bạn có chắc xóa bản ghi này không ?')"
                                                            class="btn btn-danger btn-sm rounded-2 text-white" type="button"
                                                            data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                                class="fa fa-trash"></i></a>
                                                    @endcan
                                                @else
                                                    @can('page.edit')
                                                        <a href="{{ route('page.edit', $page->page_id) }}"
                                                            class="btn btn-success btn-sm rounded-2 text-white" type="button"
                                                            data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                                class="fa fa-edit"></i></a>
                                                    @endcan
                                                    @can('page.delete')
                                                        <a href="{{ route('delete_page', $page->page_id) }}"
                                                            onclick="return confirm('Bạn có chắc xóa bản ghi này không ?')"
                                                            class="btn btn-danger btn-sm rounded-2 text-white" type="button"
                                                            data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                                class="fa fa-trash"></i></a>
                                                    @endcan
                                                @endif
                                            </td>
                                        @endcanany
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="12" class="text-center">Không tìm thấy bản ghi nào !!!</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </form>
                {{ $pages->links() }}
            </div>
        </div>
    </div>
@endsection
