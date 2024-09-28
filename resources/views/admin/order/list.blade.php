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
                <h5 class="m-0 mt-2 mb-2 p-0 fw-bold"><i class="fa-solid fa-list-ul"></i> Danh sách Đơn hàng</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div class="analytic">
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'all']) }}" class="text-primary">Tất cả
                            <span class="text-muted">({{ $count[0] }})</span></a>
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'pending']) }}" class="text-primary">Chờ
                            xử lý<span class="text-muted">({{ $count[1] }})</span></a>
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'processing']) }}" class="text-primary">Đang xử
                            lý
                            <span class="text-muted">({{ $count[2] }})</span></a>
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'delivered']) }}" class="text-primary">Đang vận
                            chuyển
                            <span class="text-muted">({{ $count[4] }})</span></a>
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'shipped']) }}" class="text-primary">Hoàn
                            thành
                            <span class="text-muted">({{ $count[3] }})</span></a>
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'canceled']) }}" class="text-primary">Đơn hàng
                            hủy
                            <span class="text-muted">({{ $count[5] }})</span></a>
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'trash']) }}" class="text-primary">Thùng rác
                            <span class="text-muted">({{ $count[6] }})</span></a>
                    </div>
                    <div class="form-search form-inline col-3">
                        <form action="#" class="d-flex">
                            <input type="text" class="form-control form-search" name="keyword" placeholder="Tìm kiếm"
                                value="{{ request()->input('keyword') }}">
                            <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-dark">
                        </form>
                    </div>
                </div>
                <form action="{{ url('admin/order/action') }}">
                    <div class="form-action form-inline py-3 col-3 d-flex">
                        <select class="form-control mr-1" name="act" id="">
                            <option>Chọn</option>
                            @foreach ($list_act as $key => $act)
                                <option value="{{ $key }}">{{ $act }}</option>
                            @endforeach
                        </select>
                        <input type="submit" name="btn-search" value="Áp dụng"
                            onclick="return confirm('Bạn có chắc thực hiện điều chỉnh này !')" class="btn btn-dark">
                    </div>
                    <table class="table table-hover table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center align-items-center">
                                    <input type="checkbox" name="checkall">
                                </th>
                                <th scope="col" class="text-center align-items-center">STT</th>
                                <th scope="col" class="text-center align-items-center">Mã đơn</th>
                                <th scope="col" class="text-center align-items-center">Khách hàng</th>
                                {{-- <th scope="col" class="text-center align-items-center">Sản phẩm</th> --}}
                                <th scope="col" class="text-center align-items-center">Số lượng sản phẩm</th>
                                <th scope="col" class="text-center align-items-center">Tổng tiền</th>
                                <th scope="col" class="text-center align-items-center">Trạng thái đơn hàng</th>
                                <th scope="col" class="text-center align-items-center">Thời gian</th>
                                @canany ('order.edit', 'order.delete')
                                <th scope="col" class="text-center align-items-center">Tác vụ</th>
                                @endcanany
                            </tr>
                        </thead>
                        <tbody>
                            @if ($orders != null && $orders->total() > 0)
                                @php
                                    $t = 1;
                                @endphp
                                @foreach ($orders as $list)
                                    <tr>
                                        <td class="text-center align-items-center">
                                            <input type="checkbox" name="list_check[]" value="{{ $list->order_id }}">
                                        </td>
                                        <td class="text-center align-items-center">{{ $t++ }}
                                        </td>
                                        <td class="text-center align-items-center">{{ $list->order_code ?? '---' }}</td>
                                        <td class="text-center align-items-center">
                                            {{ $list->customer->fullname ?? '' }} <br>
                                            <span
                                                class="text-info fw-bold">{{ $list->customer->phone_number ?? '---' }}</span>
                                        </td>
                                        {{-- <td class="text-center align-items-center"><a
                                                href="">{{ $list->product_title ?? '' }}</a>
                                        </td> --}}
                                        <td class="text-center align-items-center">{{ $list->product_quantity ?? '---' }}
                                        </td>
                                        <td class="text-center align-items-center">
                                            {{ number_format($list->total_amount, 0, ',', '.') }}
                                            vnd</td>
                                        <td class="text-center align-items-center">
                                            @if ($list->status == 'pending')
                                                <span class="badge bg-warning">Chờ xử lý</span>
                                            @elseif ($list->status == 'shipped')
                                                <span class="badge bg-success">Hoàn thành</span>
                                            @elseif ($list->status == 'processing')
                                                <span class="badge bg-info">Đang xử lý</span>
                                            @elseif ($list->status == 'delivered')
                                                <span class="badge bg-primary">Đang vận chuyển</span>
                                            @elseif ($list->status == 'canceled')
                                                <span class="badge bg-secondary">Đã hủy</span>
                                            @endif
                                        </td>
                                        <td class="text-center align-items-center">
                                            {{ $list->created_at->format('d/m/Y H:i:s') ?? '' }}</td>
                                        {{-- <td class="text-center align-items-center">
                                            <a href="#" class="btn btn-success btn-sm rounded-0 text-white"
                                                type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                    class="fa fa-edit"></i></a>
                                            <a href="{{ route('delete_order', $list->order_id) }}"
                                                class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                onclick="return confirm('Bạn có chắc xóa bản ghi này không ?')"
                                                data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                    class="fa fa-trash"></i></a>
                                        </td> --}}
                                        @canany(['order.edit', 'order.delete'])
                                            <td class="text-center align-items-center">
                                                @if ($list->deleted_at != null)
                                                    @can('order.delete')
                                                        <a href="{{ route('delete_order', $list->order_id) }}"
                                                            class="btn btn-danger btn-sm rounded-2 text-white" type="button"
                                                            data-toggle="tooltip" data-placement="top"
                                                            onclick="return confirm('Bạn có chắc xóa bản ghi này không ?')"
                                                            title="Delete"><i class="fa fa-trash"></i></a>
                                                    @endcan
                                                @else
                                                    @can('order.edit')
                                                        <a href="{{ route('order.edit', $list->order_id) }}"
                                                            class="btn btn-success btn-sm rounded-2 text-white" type="button"
                                                            data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                                class="fa fa-edit"></i></a>
                                                    @endcan
                                                    @can('order.delete')
                                                        <a href="{{ route('delete_order', $list->order_id) }}"
                                                            class="btn btn-danger btn-sm rounded-2 text-white" type="button"
                                                            data-toggle="tooltip" data-placement="top"
                                                            onclick="return confirm('Bạn có chắc xóa bản ghi này không ?')"
                                                            title="Delete"><i class="fa fa-trash"></i></a>
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
                {{ $orders->links() }}
            </div>
        </div>
    @endsection
