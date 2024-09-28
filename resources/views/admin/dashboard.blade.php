@extends('layouts.admin')

@section('content')
    <style>
        .box {
            transition: transform 0.5s ease, background-color 0.5s ease, box-shadow 0.5s ease;
            max-width: 20rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            border-radius: 10px;

            color: black;
        }

        .card {
            box-shadow: 0 12px 15px rgba(0, 0, 0, 0.3);
        }

        .box:hover {
            /* transform: scale(1.02); */
            color: white;
            transform: translateY(-5px);
            background-color: #4f4f4f !important;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.3);
        }

        tbody>tr {
            transition: transform 0.5s ease, background-color 0.5s ease, box-shadow 0.5s ease;
        }

        tbody>tr:hover {
            transform: scale(1.002);
            box-shadow: 0 3px 5px rgba(0, 0, 0, 0.3);

        }
    </style>
    <div class="container-fluid py-5">
        <div class="row">


            {{-- <div class="offcanvas offcanvas-bottom" id="demo">
            <div class="offcanvas-header">
              <h1 class="offcanvas-title">Heading</h1>
              <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
              <p>Some text lorem ipsum.</p>
              <p>Some text lorem ipsum.</p>
              <button class="btn btn-secondary" type="button">A Button</button>
            </div>
          </div> --}}

            <!-- Button to open the offcanvas sidebar -->

            <div class="col-3">
                <div class="card box fw-bold mb-3" data-bs-toggle="offcanvas" data-bs-target="#demo"
                    style="background-color:rgb(255, 255, 255);">
                    <div class="card-header p-3 border-0">ĐƠN HÀNG THÀNH CÔNG</div>
                    <div class="card-body p-4">
                        <h5 class="card-title">{{ $count['shipped'] }} ĐƠN</h5>
                        <p class="card-text">Đơn hàng giao dịch thành công</p>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card box fw-bold mb-3" style="background-color:rgb(255, 255, 255);">
                    <div class="card-header p-3 border-0">ĐANG XỬ LÝ</div>
                    <div class="card-body p-4">
                        <h5 class="card-title">{{ $count['processing'] }} ĐƠN</h5>
                        <p class="card-text">Số lượng đơn hàng đang xử lý</p>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card box fw-bold mb-3" style="background-color:rgb(255, 255, 255);">
                    <div class="card-header p-3 border-0">ĐANG VẬN CHUYỂN</div>
                    <div class="card-body p-4">
                        <h5 class="card-title">{{ $count['delivered'] }} ĐƠN</h5>
                        <p class="card-text">Đơn hàng đang vận chuyển</p>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card box fw-bold mb-3" style="background-color:rgb(255, 255, 255);">
                    <div class="card-header p-3 border-0">ĐƠN HÀNG HỦY</div>
                    <div class="card-body p-4">
                        <h5 class="card-title">{{ $count['canceled'] }} ĐƠN</h5>
                        <p class="card-text">Số đơn bị hủy trong hệ thống</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                <div class="card box fw-bold mb-3" style="background-color:rgb(255, 255, 255);">
                    <div class="card-header p-3 border-0">DOANH SỐ</div>
                    <div class="card-body p-4">
                        <h5 class="card-title">{{ number_format($count['total_amount']) }} VND</h5>
                        <p class="card-text">Doanh số hệ thống</p>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card box fw-bold mb-3" style="background-color:rgb(255, 255, 255);">
                    <div class="card-header p-3 border-0">TỔNG SẢN PHẨM TRONG KHO</div>
                    <div class="card-body p-4">
                        <h5 class="card-title">{{ $count['total_product'] }} SẢN PHẨM</h5>
                        <p class="card-text">Số lượng sản phẩm trong kho</p>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card box fw-bold mb-3" style="background-color:rgb(255, 255, 255);">
                    <div class="card-header p-3 border-0">TỔNG SẢN PHẨM BÁN RA</div>
                    <div class="card-body p-4">
                        <h5 class="card-title">{{ $count['sale_product'] }} SẢN PHẨM</h5>
                        <p class="card-text">Số lượng sản phẩm đã bán</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- end analytic  -->
        <div class="card mt-3">
            <div class="card-header fw-bold">
                <i class="fa-brands fa-shopify"></i> ĐƠN HÀNG MỚI
            </div>
            <div class="card-body">
                <table class="table table-hover table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" class="text-center align-items-center">STT</th>
                            <th scope="col" class="text-center align-items-center">Mã đơn hàng</th>
                            <th scope="col" class="text-center align-items-center">Khách hàng</th>
                            <!-- <th scope="col" class="text-center align-items-center">Sản phẩm</th> -->
                            <th scope="col" class="text-center align-items-center">Số lượng sản phẩm</th>
                            <th scope="col" class="text-center align-items-center">Tổng giá trị</th>
                            <th scope="col" class="text-center align-items-center">Trạng thái đơn hàng</th>
                            <th scope="col" class="text-center align-items-center">Thời gian đặt hàng</th>
                            @canany(['order.edit' ,'order.delete'])
                                <th scope="col" class="text-center align-items-center">Tác vụ</th>
                            @endcanany
                        </tr>
                    </thead>
                    <tbody>
                        @if ($new_orders != null && $new_orders->total() > 0)
                            @php
                                $t = 1;
                            @endphp
                            @foreach ($new_orders as $list)
                                <tr>
                                    <td class="text-center align-items-center" scope="row">{{ $t++ }}</td>
                                    <td class="text-center align-items-center">{{ $list->order_code }}</td>
                                    <td class="text-center align-items-center">
                                        {{ $list->customer->fullname ?? '' }} <br>
                                        <span class="text-info">
                                            {{ $list->customer->phone_number ?? '' }}
                                        </span>
                                    </td>
                                    <!-- <td class="text-center align-items-center"><a class="text-dark" href="#">{{ $list->product_title ?? '' }}</a></td> -->
                                    <td class="text-center align-items-center">{{ $list->product_quantity ?? '' }}</td>
                                    <td class="text-center align-items-center">
                                        {{ number_format($list->total_amount) ?? '' }} vnđ</td>
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
                                    @canany(['order.edit', 'order.delete'])
                                        <td class="text-center align-items-center">
                                            @can('order.edit')
                                                <a href="{{ route('order.edit', $list->order_id) }}"
                                                    class="btn btn-success btn-sm rounded-2 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                        class="fa fa-edit"></i></a>
                                            @endcan
                                            @can('order.delete')
                                                <a href="{{ route('delete_order', $list->order_id) }}"
                                                    class="btn btn-danger btn-sm rounded-2 text-white"
                                                    onclick="return confirm('Bạn có chắc xóa bản ghi này không ?')" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                        class="fa fa-trash"></i></a>
                                            @endcan
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
                {{ $new_orders->links() }}

            </div>
        </div>

    </div>
@endsection
