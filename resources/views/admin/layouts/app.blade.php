<!DOCTYPE html> <html lang="id"> <head> <meta charset="UTF-8"> <meta name="viewport" content="width=device-width, initial-scale=1"> <title>UMKM</title>
<link href="{{ asset('assets-admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets-admin/css/sb-admin-2.min.css') }}" rel="stylesheet">

@stack('styles')

</head> <body id="page-top"> <div id="wrapper">
@include('admin.layouts.sidebar')

<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">

        @include('admin.layouts.navbar')

        <div class="container-fluid">
            @yield('content')
        </div>

    </div>
</div>

</div> <script src="{{ asset('assets-admin/vendor/jquery/jquery.min.js') }}"></script> <script src="{{ asset('assets-admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script> <script src="{{ asset('assets-admin/js/sb-admin-2.min.js') }}"></script>

@stack('scripts')

</body> </html>
