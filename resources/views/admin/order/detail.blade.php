@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        @foreach ($ordered as $item)
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
                <div class="card-header fw-bold">
                    <h5 class="m-0 mt-2 mb-2 p-0 fw-bold"><i class="fa-solid fa-pen-to-square"></i> Chi tiết đơn hàng -
                        {{ $item->order_code }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">

                            <div class="fw-bold mb-3">
                                <i class="fa-solid fa-signal text-info mb-3"></i> <span class="text-info">Trạng thái đơn
                                    hàng:</span>
                                @if ($item->status == 'pending')
                                    <span class="badge bg-warning">Chờ xử lý</span>
                                @elseif ($item->status == 'shipped')
                                    <span class="badge bg-success">Hoàn thành</span>
                                @elseif ($item->status == 'processing')
                                    <span class="badge bg-info">Đang xử lý</span>
                                @elseif ($item->status == 'delivered')
                                    <span class="badge bg-primary">Đang vận chuyển</span>
                                @elseif ($item->status == 'canceled')
                                    <span class="badge bg-secondary">Đã hủy</span>
                                @endif
                                <form action="{{ route('order.update', $item->order_id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <div class="d-flex my-2">
                                            <select class="form-select" name="status" aria-label="Default select example">
                                                <option value="0" class="form-control">--Cập nhật trạng thái đơn hàng--
                                                </option>
                                                <option value="pending" {{ $item->status == 'pending' ? 'selected' : '' }}>
                                                    Chờ xử lý</option>
                                                <option value="shipped" {{ $item->status == 'shipped' ? 'selected' : '' }}>
                                                    Hoàn thành</option>
                                                <option value="processing"
                                                    {{ $item->status == 'processing' ? 'selected' : '' }}>Đang xử lý
                                                </option>
                                                <option value="delivered"
                                                    {{ $item->status == 'delivered' ? 'selected' : '' }}>Đang vận chuyển
                                                </option>
                                                <option value="canceled"
                                                    {{ $item->status == 'canceled' ? 'selected' : '' }}>Đã hủy</option>
                                            </select>
                                            <button type="submit" name="btn-update"
                                                class="btn btn-warning form-control w-25">Cập nhật</button>
                                        </div>
                                </form> 
                            </div>
                        </div>
                        <div class="fw-bold my-2">
                            <i class="fa-solid fa-circle-info text-info"></i> <span class="text-info">Thông tin sản
                                phẩm</span>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col" class="text-center">STT</th>
                                        <th scope="col" class="text-center">Ảnh</th>
                                        <th scope="col" class="text-center">Tên sản phẩm</th>
                                        <th scope="col" class="text-center">Đơn giá</th>
                                        <th scope="col" class="text-center">Số lượng</th>
                                        <th scope="col" class="text-center">Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $t = 0;
                                    @endphp
                                    @foreach ($order_item as $temp)
                                        @php
                                            $t++;
                                        @endphp
                                        <tr>
                                            <td class="text-center align-items-center">{{ $t }}</td>
                                            <td scope="col" class="text-center align-items-center">
                                                <div title="" class="thumb">
                                                    <img src="{{ url($temp->product->image->image_url) ?? '' }}"
                                                        style="width: 150px; height:80px;" alt="Current Image">
                                                </div>
                                            </td>
                                            <td scope="col" class="text-center align-items-center">
                                                <div title="" class="name-product text-dark">
                                                    {{ $temp->product->product_title ?? '' }}</div>
                                            </td>
                                            <td scope="col" id="price" class="text-center align-items-center">
                                                {{ number_format($temp->price, 0, ',', '.') ?? '' }} vnđ</td>
                                            <td scope="col" class="text-center">
                                                <div>{{ $temp->quantity ?? '' }}</div>
                                            </td>
                                            <td scope="col" class="sub-total text-center align-items-center">
                                                {{ number_format($sub_total = $temp->price * $temp->quantity, 0, ',', '.') }}
                                                vnđ</td>
                                        </tr>
                                    @endforeach
                                    <tr class="table table-secondary">
                                        <td colspan="4">
                                            <p id="total-price"
                                                class="text-danger fw-bold text-center align-items-center mb-0">Tổng
                                                thanh toán</p>
                                        </td>
                                        <td>
                                            <p class="text-danger fw-bold text-center align-items-center mb-0">
                                                {{ $item->product_quantity }}</p>
                                        </td>
                                        <td>
                                            <div id="total-price" class="text-center fw-bold">
                                                <span
                                                    class="text-danger">{{ number_format($item->total_amount, 0, ',', '.') }}
                                                    vnd</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-3">
                        <i class="fa-solid fa-address-card text-info"></i> <span class="fw-bold my-2 text-info">Khách
                            hàng</span>
                        <div class="card mt-4">
                            <div class="card-body">
                                <div class="mb-3">
                                    <h6 class="fw-bold my-2"><i class="fa-solid fa-user-pen"></i> HỌ VÀ TÊN</h6>
                                    <span>{{ $item->customer->fullname ?? '' }}</span>
                                </div>
                                <div class="mb-3">
                                    <h6 class="fw-bold my-2"><i class="fa-solid fa-square-phone"></i> SỐ ĐIỆN THOẠI</h6>
                                    <span>{{ $item->customer->phone_number ?? '---' }}</span>
                                </div>
                                <div class="mb-3">
                                    <h6 class="fw-bold my-2"><i class="fa-solid fa-envelope"></i> EMAIL</h6>
                                    <span>{{ $item->customer->email ?? '---' }}</span>
                                </div>
                                <div class="mb-3">
                                    <h6 class="fw-bold my-2"><i class="fa-solid fa-location-dot"></i> ĐỊA CHỈ</h6>
                                    <span>{{ $item->customer->address ?? '---' }}</span>
                                </div>
                                <div class="mb-3">
                                    <h6 class="fw-bold my-2"><i class="fa-solid fa-calendar-day"></i> NGÀY ĐẶT HÀNG
                                    </h6>
                                    <span>{{ $item->created_at ?? '---' }}</span>
                                </div>
                                <div class="mb-3">
                                    <h6 class="fw-bold my-2"><i class="fa-solid fa-message"></i> CHÚ THÍCH</h6>
                                    <span>{{ $item->note ?? '---' }}</span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    @endforeach
    </div>
    </div>
@endsection
