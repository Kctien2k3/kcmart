<!DOCTYPE html>
<html lang="en">

@include('layouts.header')

<body>
    <div class="page-container">
        {{-- @include('layouts.sidebar') --}}

        <div class="main-container">
            @yield('content')
        </div>

        @include('layouts.footer')</div>

</body>
