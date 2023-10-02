<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="_token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link href="{{ asset('plugins/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/toastr/toastr.min.css') }}" rel="stylesheet">
    <link href="{{ asset('fonts/inter/style.css') }}" rel="stylesheet">
    <link href="{{ asset('fonts/fontawesome/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('fonts/bootstrap/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/layouts/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/layouts/responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('style')
</head>
<body>
@include('layouts.header')
@include('layouts.leftSidebar')
<div class="mobile-menu-overlay"></div>
<div class="main-container">
    @yield('content')
</div>
<script src="{{ asset('plugins/jquery/jquery-3.6.3.min.js') }}"></script>
<script src="{{ asset('fonts/fontawesome/js/all.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/popper.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/bootstrap.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('js/layouts/script.js') }}"></script>
@yield('script')
<script type="text/javascript">
    @if(session('status_success'))
        toastr.options.timeOut = 2000;
        toastr.success('{{session('status_success')}}');
    @elseif(session('status_error'))
        toastr.options.timeOut = 2000;
        toastr.error('{{session('status_error')}}');
    @endif
</script>
</body>
</html>
