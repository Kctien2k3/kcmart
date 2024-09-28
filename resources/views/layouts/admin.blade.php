<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> --}}

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/solid.min.css">

    {{-- <!-- Place the first <script>
        tag in your HTML 's <head> --> <
        script src =
            "https://cdn.tiny.cloud/1/p30ns0zdvqg1acqqn71h8wvkq6l31ak16j9q75e86z6p760s/tinymce/7/tinymce.min.js"
        referrerpolicy = "origin" >
    </script>

<!-- Place the following <script>
    and < textarea > tags your HTML 's <body> --> <
    script >
        tinymce.init({
            selector: 'textarea',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount linkchecker',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        });
</script> --}}
    {{-- <textarea>
  Welcome to TinyMCE!
</textarea> --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>Admintrator</title>

</head>

<body>
    <style>
        .nav-fixed {}

        nav {
            transition: transform 0.5s ease, background-color 0.5s ease, box-shadow 0.5s ease;
        }

        nav:hover {
            transform: scale(1.001);
        }
    </style>
    <div id="warpper" class="nav-fixed">
        <nav class="topnav rounded-4 shadow navbar navbar-expand-sm bg-white">
            <div class="navbar-brand"><a href="?" class="text-dark">UNIMART ADMIN</a></div>
            <div class="nav-right">
                <div class="btn-group mr-auto">
                    <button type="button" class="btn dropdown" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="plus-icon fas fa-plus-circle"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ url('admin/post/add') }}">Thêm bài viết</a>
                        <a class="dropdown-item" href="{{ url('admin/product/add') }}">Thêm sản phẩm</a>
                        <a class="dropdown-item" href="{{ url('admin/page/add') }}">Thêm trang</a>
                    </div>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="fa-solid fa-circle-user"></i> {{ Auth::user()->name }}
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="#">Tài khoản</a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </nav>
        <!-- end nav  -->
        <style>
            .hover-bold:hover {
                font-weight: bold;
                transition: 0.1s ease-in-out;
            }

            a {
                text-decoration: none;
            }

            .logout {
                position: absolute;
                bottom: 0;
                padding: 10px;
                left: 10px;
                font-size: 25px;
            }
        </style>
        @php
            $module_active = session('module_active');
            session(['module_active' => 'page']);
        @endphp
        <div id="page-body" class="d-flex">
            <div id="sidebar" class="bg-white">
                <ul id="sidebar-menu">
                    <li class="nav-link {{ $module_active == 'dashboard' ? 'active' : '' }}">
                        <a class="text-dark {{ $module_active == 'dashboard' ? 'text-muted fw-bold' : '' }}"
                            href="{{ url('dashboard') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="fa-solid fa-dice-d6"></i>
                            </div>
                            Dashboard
                        </a>
                        {{-- <i class="arrow fas fa-angle-right"></i> --}}
                    </li>
                    @canany(['page.view'])
                        <li class="nav-link {{ $module_active == 'page' ? 'active' : '' }}">
                            <a class="text-dark {{ $module_active == 'page' ? 'text-muted fw-bold' : '' }}"
                                href="{{ url('admin/page/list') }}">
                                <div class="nav-link-icon d-inline-flex">
                                    <i class="fa-solid fa-book-open"></i>
                                </div>
                                Trang
                            </a>
                            <i class="arrow fas fa-angle-right"></i>

                            <ul class="sub-menu">
                                @can('page.add')
                                    <li><a class="text-muted hover-bold" href="{{ url('admin/page/add') }}">Thêm mới</a></li>
                                @endcan
                                <li><a class="text-muted hover-bold" href="{{ url('admin/page/list') }}">Danh sách</a></li>
                            </ul>
                        </li>
                    @endcanany
                    @canany('slider.view')
                        <li class="nav-link {{ $module_active == 'slider' ? 'active' : '' }}">
                            <a class="text-dark {{ $module_active == 'slider' ? 'text-muted fw-bold' : '' }}"
                                href="{{ url('admin/slider/list') }}">
                                <div class="nav-link-icon d-inline-flex">
                                    <i class="fa-solid fa-chalkboard"></i>
                                </div>
                                Slider
                            </a>
                            <i class="arrow fas fa-angle-right"></i>
                            <ul class="sub-menu">
                                @can('slider.add')
                                    <li><a class="text-muted hover-bold" href="{{ url('admin/slider/add') }}">Thêm mới</a></li>
                                @endcan
                                <li><a class="text-muted hover-bold" href="{{ url('admin/slider/list') }}">Danh sách</a>
                                </li>
                                {{-- <li><a class="text-muted hover-bold" href="{{url('admin/')}}">Danh mục</a></li> --}}
                            </ul>
                        </li>
                    @endcanany
                    {{-- <li class="nav-link {{$module_active == 'slide' ? 'active':''}}">
                        <a class="text-dark {{$module_active == 'slide' ? 'text-muted fw-bold' : ''}}" href="{{url('admin/')}}">
                            <div class="nav-link-icon d-inline-flex">
                                <!-- <i class="far fa-folder"></i> -->
                                 <i class="fa-solid fa-money-check"></i>
                            </div>
                            Banner
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                        <ul class="sub-menu">
                            <li><a class="text-muted hover-bold" href="{{url('admin/')}}">Thêm mới</a></li>
                            <li><a class="text-muted hover-bold" href="{{url('admin/')}}">Danh sách</a></li>
                            <li><a class="text-muted hover-bold" href="{{url('admin/')}}">Danh mục</a></li>
                        </ul>
                    </li> --}}
                    {{-- <li class="nav-link {{$module_active == 'menu' ? 'active' : ''}}">
                        <a class="text-dark {{$module_active == 'menu' ? 'text-muted fw-bold' : ''}}" href="{{url('admin/menu/list')}}">
                            <div class="nav-link-icon d-inline-flex">
                            <i class="fa-solid fa-rectangle-list"></i>
                            </div>
                            Menu
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                        <ul class="sub-menu">
                            <li><a class="text-muted hover-bold" href="{{url('admin/menu/add')}}">Thêm mới</a></li>
                            <li><a class="text-muted hover-bold" href="{{url('admin/menu/list')}}">Danh sách</a></li>
                            <li><a class="text-muted hover-bold" href="{{url('admin/')}}">Danh mục</a></li>
                        </ul>
                    </li> --}}
                    @canany('post.view')
                        <li class="nav-link {{ $module_active == 'post' ? 'active' : '' }}">
                            <a class="text-dark {{ $module_active == 'post' ? 'text-muted fw-bold' : '' }}"
                                href="{{ url('admin/post/list') }}">
                                <div class="nav-link-icon d-inline-flex">
                                    <i class="fa-solid fa-file-pen"></i>
                                </div>
                                Bài viết
                            </a>
                            <i class="arrow fas fa-angle-right"></i>
                            <ul class="sub-menu">
                                @can('post.add')
                                    <li><a class="text-muted hover-bold" href="{{ url('admin/post/add') }}">Thêm mới</a></li>
                                @endcan
                                <li><a class="text-muted hover-bold" href="{{ url('admin/post/list') }}">Danh sách</a></li>
                                @can('post.view_cat')
                                    <li><a class="text-muted hover-bold" href="{{ url('admin/post/cat/list_cat') }}">Danh
                                            mục</a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany
                    @canany('product.view')
                        <li class="nav-link {{ $module_active == 'product' ? 'active' : '' }}">
                            <a class="text-dark {{ $module_active == 'product' ? 'text-muted fw-bold' : '' }}"
                                href="{{ url('admin/product/list') }}">
                                <div class="nav-link-icon d-inline-flex">
                                    <i class="fa-solid fa-boxes-packing"></i>
                                </div>
                                Sản phẩm
                            </a>
                            <i class="arrow fas fa-angle-right"></i>
                            <ul class="sub-menu">
                                @can('product.add')
                                    <li><a class="text-muted hover-bold" href="{{ url('admin/product/add') }}">Thêm mới</a>
                                    </li>
                                @endcan
                                <li><a class="text-muted hover-bold" href="{{ url('admin/product/list') }}">Danh sách</a>
                                </li>
                                @can('product.view_cat')
                                    <li><a class="text-muted hover-bold" href="{{ url('admin/product/cat/list_cat') }}">Danh
                                            mục</a></li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany
                    @canany('order.view')
                        <li class="nav-link {{ $module_active == 'order' ? 'active' : '' }}">
                            <a class="text-dark {{ $module_active == 'order' ? 'text-muted fw-bold' : '' }}"
                                href="{{ url('admin/order/list') }}">
                                <div class="nav-link-icon d-inline-flex">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                </div>
                                Đơn hàng
                            </a>
                            {{-- <i class="arrow fas fa-angle-right"></i>
                    <ul class="sub-menu">
                        <li><a class="text-muted hover-bold" href="{{url('admin/order/list')}}">Đơn hàng</a></li>
                    </ul> --}}
                        </li>
                    @endcanany
                    @canany('user.view')
                        <li class="nav-link {{ $module_active == 'user' ? 'active' : '' }}">
                            <a class="text-dark {{ $module_active == 'user' ? 'text-muted fw-bold' : '' }}"
                                href="{{ url('admin/user/list') }}">
                                <div class="nav-link-icon d-inline-flex">
                                    <i class="fa-solid fa-user-group"></i>
                                </div>
                                Users
                            </a>
                            <i class="arrow fas fa-angle-right"></i>

                            <ul class="sub-menu">
                                @can('user.add')
                                    <li><a class="text-muted hover-bold" class="text-muted"
                                            href="{{ url('admin/user/add') }}">Thêm mới</a></li>
                                @endcan
                                <li><a class="text-muted hover-bold" class="text-muted"
                                        href="{{ url('admin/user/list') }}">Danh sách</a></li>
                            </ul>
                        </li>
                    @endcanany
                    @canany('role.view')
                        <li class="nav-link  {{ $module_active == 'role' ? 'active' : '' }}">
                            <a class="text-dark  {{ $module_active == 'role' ? 'text-muted fw-bold' : '' }}"
                                href="{{ route('role.index') }}">
                                <div class="nav-link-icon d-inline-flex">
                                    <i class="fa-solid fa-users-gear"></i>
                                </div>
                                Phân quyền
                            </a>
                            <i class="arrow fas fa-angle-right"></i>
                            <ul class="sub-menu">
                                @can('permission.add')
                                    <li><a class="text-muted hover-bold" href="{{ route('permission.add') }}">Quyền</a></li>
                                @endcan
                                @can('role.add')
                                    <li><a class="text-muted hover-bold" href="{{ route('role.add') }}">Thêm vai trò</a></li>
                                @endcan
                                <li><a class="text-muted hover-bold" href="{{ route('role.index') }}">Danh sách vai
                                        trò</a></li>
                            </ul>
                        </li>
                    @endcanany

                    <!-- <li class="nav-link"><a>Bài viết</a>
                        <ul class="sub-menu">
                            <li><a>Thêm mới</a></li>
                            <li><a>Danh sách</a></li>
                            <li><a>Thêm danh mục</a></li>
                            <li><a>Danh sách danh mục</a></li>
                        </ul>
                    </li>
                    <li class="nav-link"><a>Sản phẩm</a></li>
                    <li class="nav-link"><a>Đơn hàng</a></li>
                    <li class="nav-link"><a>Hệ thống</a></li> -->

                    {{-- <li class="nav-link logout">
                        <a class="text-dark"href="?view=permission">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="fa-solid fa-right-from-bracket"></i>
                            </div>
                            Logout
                        </a>
                    </li> --}}
                </ul>
            </div>
            <div id="wp-content">
                @yield('content')
            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"
        integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>
