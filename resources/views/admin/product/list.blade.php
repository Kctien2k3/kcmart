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
            </div>
            <div class="card-header fw-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 mt-2 mb-2 p-0 fw-bold"><i class="fa-solid fa-list-ul"></i> Danh sách sản phẩm</h5>
                <div class="form-search form-inline">
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div class="analytic">
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'active']) }}" class="text-primary">Tất cả<span
                                class="text-muted"> ({{ $count[0] }})</span></a>
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'actived']) }}" class="text-primary">Đã
                            đăng<span class="text-muted"> ({{ $count[2] }})</span></a>
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'inactived']) }}" class="text-primary">Chờ
                            duyệt<span class="text-muted"> ({{ $count[3] }})</span></a>
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'trash']) }}" class="text-primary">Thùng
                            rác<span class="text-muted"> ({{ $count[1] }})</span></a>
                    </div>
                    <div class="form-search form-inline col-3">
                        <form action="#" class="d-flex">
                            <input type="" class="form-control form-search" name="keyword"
                                value="{{ request()->input('keyword') }}" placeholder="Tìm kiếm">
                            <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-dark">
                        </form>
                    </div>
                </div>
                <form action="{{ url('admin/product/action') }}">
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
                                <th scope="col" class="text-center align-items-center">
                                    <input name="checkall" type="checkbox">
                                </th>
                                <th scope="col" class="text-center align-items-center">STT</th>
                                <th scope="col" class="text-center align-items-center">Ảnh</th>
                                <th scope="col" class="text-center align-items-center">Tên sản phẩm</th>
                                <th scope="col" class="text-center align-items-center">Giá</th>
                                {{-- <th scope="col" class="text-center align-items-center">Giảm giá</th> --}}
                                <th scope="col" class="text-center align-items-center">Danh mục</th>
                                <th scope="col" class="text-center align-items-center">Trạng thái</th>
                                <th scope="col" class="text-center align-items-center">Người tạo-Ngày tạo</th>
                                @canany(['product.edit', 'product.delete'])
                                    <th scope="col" class="text-center align-items-center">Tác vụ</th>
                                @endcanany
                            </tr>
                        </thead>
                        <tbody>
                            @if ($products != null && $products->total() > 0)
                                @php
                                    $t = 1;
                                @endphp
                                @foreach ($products as $product)
                                    <tr class="text-center align-items-center">
                                        <td>
                                            <input type="checkbox" name="list_check[]"
                                                value="{{ $product->product_id ?? '---' }}">
                                        </td>
                                        <td class="text-center align-items-center">{{ $t++ }}
                                        </td>
                                        <td class="text-center align-items-center">
                                            <img src="{{ url($product->image->image_url ?? '---') }}"
                                                style="width: auto; height:80px;" alt="Current Image">
                                        </td>
                                        <td class="text-center align-items-center text-truncate" style="max-width: 250px;" data-bs-toggle="tooltip" 
                                        data-bs-placement="bottom" 
                                        title="{{ $product->product_title }}"><a class="text-dark"
                                                href="#">{{ $product->product_title }}</a></td>
                                        <td class="text-center align-items-center">{{ number_format($product->product_price, 0, ',', '.') }} vnđ</td>
                                        {{-- <td class="text-center align-items-center">{{$product->product_sale}}</td> --}}
                                        <td class="text-center align-items-center">
                                            {{ $product->product_category->category_name ?? '---' }}</td>
                                        <td class="text-center align-items-center">
                                            @if ($product->product_status == 'active')
                                                <span class="badge bg-success">Còn hàng</span>
                                            @elseif ($product->product_status == 'inactive')
                                                <span class="badge bg-warning">Chờ duyệt</span>
                                            @endif
                                        </td>
                                        <td class="text-center align-items-center">
                                            {{ $product->user->name ?? '---' }}<br>{{ $product->created_at->format('d/m/Y H:i:s') ?? '---' }}
                                        </td>
                                        @canany(['product.edit', 'product.delete'])
                                            <td class="text-center align-items-center">
                                                @if ($product->deleted_at != null)
                                                    @can('product.delete')
                                                        <a href="{{ route('product.delete', $product->product_id) }}"
                                                            onclick="return confirm('Bạn có chắc xóa bản ghi này không ?')"
                                                            class="btn btn-danger btn-sm rounded-2 text-white" type="button"
                                                            data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                                class="fa fa-trash"></i></a>
                                                    @endcan
                                                @else
                                                    @can('product.edit')
                                                        <a href="{{ route('product.edit', $product->product_id) }}"
                                                            class="btn btn-success btn-sm rounded-2 text-white" type="button"
                                                            data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                                class="fa fa-edit"></i></a>
                                                    @endcan
                                                    @can('product.delete')
                                                        <a href="{{ route('product.delete', $product->product_id) }}"
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
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection
