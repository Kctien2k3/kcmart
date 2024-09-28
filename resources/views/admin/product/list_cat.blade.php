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
        <div class="row">
            <div class="col-4">
                <div class="card">
                    <div class="card-header fw-bold">
                    <h5 class="m-0 mt-2 mb-2 p-0 fw-bold"><i class="fa-solid fa-folder-plus"></i> Thêm danh mục sản phẩm</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('admin/product/cat/add_cat') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name" class="fw-bold my-2">Tên danh mục</label>
                                <input class="form-control" type="text" name="category_name" id="name">
                                @error('category_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name" class="fw-bold my-2">Đường dẫn danh mục</label>
                                <input class="form-control" type="text" name="category_slug" id="name">
                                @error('category_slug')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="" class="fw-bold my-2">Danh mục cha</label>
                                <select class="form-control" name="parent_id" id="">
                                    <option value="0">--Chọn danh mục--</option>
                                   {!! $ShowCategories !!}
                                    
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="" class="fw-bold my-2">Trạng thái</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="category_status"
                                        id="exampleRadios1" value="draft">
                                    <label class="form-check-label" for="exampleRadios1">
                                        Chờ duyệt
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="category_status"
                                        id="exampleRadios2" value="published">
                                    <label class="form-check-label" for="exampleRadios2">
                                        Công khai
                                    </label>
                                </div>
                                @error('category_status')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <button type="submit" name="btn-add" class="btn btn-warning mt-3 form-control">Thêm mới</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-8">
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
                    <h5 class="m-0 mt-2 mb-2 p-0 fw-bold"><i class="fa-solid fa-bars-staggered"></i> danh mục sản phẩm</h5>
                    </div>
                    <form action="{{ url('admin/product/cat/delele_cat') }}">
                        <div class="card-body">
                            <table class="table table-hover table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col" class="text-center">STT</th>
                                        <th scope="col">Tên danh mục</th>
                                        <th scope="col" class="text-center">Trạng thái</th>
                                        <th scope="col" class="text-center">Người tạo</th>
                                        <th scope="col" class="text-center">Ngày tạo</th>
                                        <th scope="col" class="text-center">Tác vụ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        function TableCategories($categories, $parent_id = 0, $char = '', &$t = 0)
                                        {               
                                            foreach ($categories as $key => $item) {     
                                                if ($item->parent_id == $parent_id) {
                                                    $t++;
                                                    echo '<tr>';
                                                    echo '<th scope="row" class="text-center">' . $t . '</th>';
                                                    echo '<td>' . $char . $item->category_name . '</td>';
                                                    echo '<td class="text-center">' .
                                                        ($item->category_status == 'draft'
                                                            ? '<span class="badge bg-warning">' .
                                                                "Chờ duyệt" .
                                                                '</span>'
                                                            : ($item->category_status == 'published'
                                                                ? '<span class="badge bg-success">' .
                                                                    "Công khai" .
                                                                    '</span>'
                                                                : '')) .
                                                        '</td>';
                                                    echo '<td class="text-center">' .( $item->user->name ?? '---') . '</td>';
                                                    echo '<td class="text-center">' . ($item->created_at->format('d/m/Y H:i:s') ?? '---') . '</td>';
                                                    echo '<td class="text-center">'; // Open a new <td> for buttons
                                                    echo '<a href="' .
                                                         route('category.edit', ['category_id' => $item->category_id]) .
                                                        '" class="btn btn-success btn-sm rounded-1 text-white mx-1" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>';
                                                    echo '<a href="' .
                                                        route('delete_cat', ['category_id' => $item->category_id]) .
                                                        '" onclick="return confirm(\'Bạn có chắc xóa bản ghi này không ?\')" class="btn btn-danger btn-sm rounded-1 text-white mx-1" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>';
                                                    echo '</td>'; // Close the <td> for buttons
                                                    echo '</tr>';
                                                    // xóa chuyên mục đã lặp
                                                    unset($categories[$key]);

                                                    // tiếp tục đệ quy để tìm chuyên mục con của chuyên mục đã lập
                                                    TableCategories($categories, $item->category_id, $char . ' -- ', $t);
                                                }
                                            }
                                        }
                                    @endphp
                                    @php
                                      $t = 0;
                                        TableCategories($categories, 0, '', $t);
                                    @endphp
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
