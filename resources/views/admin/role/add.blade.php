@extends('layouts.admin')

@section('title', 'thêm vai trò')

@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 mt-2 mb-2 p-0 fw-bold"><i class="fa-solid fa-folder-plus"></i> thêm mới vai trò</h5>
            </div>
            <div class="card-body">
                {{-- <form method="POST" action="" enctype="multipart/form-data"> --}}
                {!! Form::open(['route' => 'role.store']) !!}
                <div class="form-group">
                    {{-- <label for="name">Tên quyền</label>
                            <input class="form-control" type="text" name="name" id="name"> --}}
                    {{ Form::label('name', 'Tên quyền', ['class' => 'fw-bold my-2']) }}
                    {{ Form::text('name', old('name'), ['class' => 'form-control', 'id' => 'name']) }}
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    {{-- <label for="description">Mô tả</label>
                            <textarea class="form-control" type="text" name="description" id="description"> </textarea> --}}
                    {{ Form::label('description', 'Mô tả', ['class' => 'fw-bold my-2']) }}
                    {{ Form::textarea('description', old('description'), ['class' => 'form-control', 'id' => 'description', 'rows' => 3]) }}
                </div>


                {{-- ////////////////////////////////////////// --}}
                <div class="mt-4">
                    <strong>Vai trò này có quyền gì?</strong><br>
                    <small class="form-text text-muted pb-2">Check vào module hoặc các hành động bên dưới để chọn
                        quyền.</small>
                </div>

                <!-- List Permission  -->
                @foreach ($permissions as $moduleName => $modulePermission)
                    <div class="card my-4 border">
                        <div class="card-header">
                            {{-- <input type="checkbox" class="check-all" name="" id="post">
                            <label for="post" class="m-0">Module Post</label> --}}
                            {{ Form::checkbox(null, null, null, ['class' => 'check-all', 'id' => $moduleName]) }}
                            {!! html_entity_decode(Form::label($moduleName, '<strong>Module ' . ucfirst($moduleName) . '</strong>')) !!}

                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach ($modulePermission as $permission)
                                    <div class="col-md-3 my-2">
                                        {{-- <input type="checkbox" class="permission" value="2" name="permission_id[]"
                                                id="post.add">
                                            <label for="post.add">Add Post</label> --}}
                                        {{ Form::checkbox('permission_id[]', $permission->id, null, [
                                            'id' => $permission->slug,
                                            'class' => 'permission btn-check',
                                            'autocomplete' => 'off',
                                        ]) }}
                                        {{ Form::label($permission->slug, $permission->name, ['class' => 'btn btn-outline-dark']) }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
                <input type="submit" name="btn-add" class="btn btn-warning mt-3 form-control" value="Thêm mới">
                {{-- </form> --}}
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('.check-all').click(function() {
            $(this).closest('.card').find('.permission').prop('checked', this.checked)
        })
    </script>
@endsection
