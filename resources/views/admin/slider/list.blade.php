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
                <h5 class="m-0 mt-2 mb-2 p-0 fw-bold"><i class="fa-solid fa-list-ul"></i> Danh sách Slider</h5>
                <div class="form-search form-inline">

                </div>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div class="analytic">
                        <a href="{{ request()->fullUrlWithQuery(['slider_status' => 'all']) }}" class="text-primary">Tất
                            cả<span class="text-muted">({{ $count[0] }})</span></a>
                        <a href="{{ request()->fullUrlWithQuery(['slider_status' => 'published']) }}"
                            class="text-primary">Đã đăng<span class="text-muted">({{ $count[1] }})</span></a>
                        <a href="{{ request()->fullUrlWithQuery(['slider_status' => 'draft']) }}" class="text-primary">Chờ
                            duyệt<span class="text-muted">({{ $count[2] }})</span></a>
                    </div>
                    <div class="form-search form-inline col-3">
                        <form action="#" class="d-flex">
                            <input type="" class="form-control form-search" name="keyword"
                                value="{{ request()->input('keyword') }}" placeholder="Tìm kiếm">
                            <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-dark">
                        </form>
                    </div>
                </div>
                <form action="{{ url('admin/slider/action') }}">
                    <div class="form-action form-inline py-3 col-3 d-flex">
                        {{-- <select class="form-control mr-1" name="act" id="">
                            <option>Chọn</option>
                            @foreach ($list_act as $key => $act)
                                <option value="{{ $key }}">{{ $act }}</option>
                            @endforeach
                        </select>
                        <input type="submit" name="btn-search" value="Áp dụng"
                            onclick="return confirm('Bạn có chắc thực hiện điều chỉnh này !')" class="btn btn-dark"> --}}
                    </div>

                    <table class="table table-hover table-bordered">
                        <thead class="table-dark">
                            <tr>
                                {{-- <th scope="col">
                                <input name="checkall" type="checkbox">
                            </th> --}}
                                <th scope="col" class="text-center align-items-center">STT</th>
                                <th scope="col" class="text-center align-items-center">Ảnh</th>
                                <th scope="col" class="text-center align-items-center">Tiêu đề</th>
                                <th scope="col" class="text-center align-items-center">Mô tả</th>
                                <th scope="col" class="text-center align-items-center">Link</th>
                                <th scope="col" class="text-center align-items-center">Trạng thái</th>
                                <th scope="col" class="text-center align-items-center">Người tạo - Ngày tạo</th>
                                @canany(['slider.edit', 'slider.delete'])
                                    <th scope="col" class="text-center align-items-center">Tác vụ</th>
                                @endcanany

                            </tr>
                        </thead>
                        <tbody>

                            @if ($sliders->total() > 0)
                                @php
                                    $t = 1;
                                @endphp
                                @foreach ($sliders as $slider)
                                    <tr class="">
                                        {{-- <td>
                                    <input type="checkbox">
                                </td> --}}
                                        <td class="text-center align-items-center">{{ $t++ }}</td>
                                        <td class="text-center align-items-center">
                                            @if (isset($slider->image->image_url))
                                                <img src="{{ url($slider->image->image_url ?? '') }}"
                                                    style="width: 200px; height:80px;" alt="Current Image">
                                            @endif
                                        <td class="text-center align-items-center"><a
                                                href="#">{{ $slider->slider_title }}</a></td>
                                        <td class="text-center align-items-center">{{ $slider->slider_desc ?? '---' }}</td>
                                        <td class="text-center align-items-center">{{ $slider->slider_url ?? '---' }}</td>
                                        <td class="text-center align-items-center">
                                            @if ($slider->slider_status == 'draft')
                                                <span class="badge bg-warning">Chờ duyệt</span>
                                            @elseif ($slider->slider_status == 'published')
                                                <span class="badge bg-success">Công khai</span>
                                            @endif
                                        </td>
                                        <td class="text-center align-items-center">
                                            {{ $slider->user->name ?? '---' }} <br />
                                            {{ $slider->created_at->format('d/m/Y H:i:s') ?? '---' }}
                                        </td>
                                        @canany(['slider.edit', 'slider.delete'])
                                            <td class="text-center align-items-center">
                                                @can('slider.edit')
                                                    <a href="{{ route('slider.edit', $slider->slider_id) }}"
                                                        class="btn btn-success btn-sm rounded-2 text-white" type="button"
                                                        data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                            class="fa fa-edit"></i></a>
                                                @endcan
                                                @can('slider.delete')
                                                    <a href="{{ route('delete_slider', ['slider_id' => $slider->slider_id, 'image_id' => $slider->image_id]) }}"
                                                        onclick="return confirm('Bạn có chắc xóa bản ghi này không ?')"
                                                        class="btn btn-danger btn-sm rounded-2 text-white" type="button"
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
                </form>
                {{ $sliders->links() }}
            </div>
        </div>
    </div>
@endsection
