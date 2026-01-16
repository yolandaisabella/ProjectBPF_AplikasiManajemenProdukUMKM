<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Dashboard UMKM</title>

<link href="{{ asset('assets-admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
<link href="{{ asset('assets-admin/css/sb-admin-2.min.css') }}" rel="stylesheet">

@stack('styles')
</head>
<body id="page-top">
    <div id="wrapper">

    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-store"></i>
            </div>
            <div class="sidebar-brand-text mx-3">UMKM</div>
        </a>

        <hr class="sidebar-divider my-0">

        <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
            <a class="nav-link" href="/">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <hr class="sidebar-divider">

        <div class="sidebar-heading">Manajemen</div>

        @if(auth()->check())
            <li class="nav-item {{ request()->is('admin/product*', 'staff/products*', 'guest/products') ? 'active' : '' }}">
                <a class="nav-link" href="{{ auth()->user()->role == 'admin' ? route('admin.product.index') : (auth()->user()->role == 'staff' ? route('staff.products.index') : route('guest.products.index')) }}">
                    <i class="fas fa-fw fa-box"></i>
                    <span>Produk</span>
                </a>
            </li>
            <li class="nav-item {{ request()->is('admin/users*', 'staff/users', 'guest/users') ? 'active' : '' }}">
                <a class="nav-link" href="{{ auth()->user()->role == 'admin' ? route('admin.users.index') : (auth()->user()->role == 'staff' ? route('staff.users') : route('guest.users')) }}">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Pengguna</span>
                </a>
            </li>
            <li class="nav-item {{ request()->is('admin/reports', 'staff/reports', 'guest/reports') ? 'active' : '' }}">
                <a class="nav-link" href="{{ auth()->user()->role == 'admin' ? route('admin.reports') : (auth()->user()->role == 'staff' ? route('staff.reports') : route('guest.reports')) }}">
                    <i class="fas fa-fw fa-chart-bar"></i>
                    <span>Laporan</span>
                </a>
            </li>
        @endif

        @if(auth()->check())
        <li class="nav-item">
            <a class="nav-link" href="{{ route('logout.confirm') }}">
                <i class="fas fa-fw fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </li>
        @endif

        <hr class="sidebar-divider d-none d-md-block">

        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">

            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        @if(auth()->check())
                            <a class="nav-link" href="#" id="cart-link" data-toggle="modal" data-target="#cartModal">
                                <i class="fas fa-shopping-cart fa-fw"></i>
                                <span class="badge badge-danger badge-counter" id="cart-counter" style="display: none;">0</span>
                            </a>
                        @else
                            <a class="nav-link" href="#" onclick="alert('Silakan login terlebih dahulu untuk melihat keranjang.'); return false;">
                                <i class="fas fa-shopping-cart fa-fw"></i>
                                <span class="badge badge-danger badge-counter" id="cart-counter" style="display: none;">0</span>
                            </a>
                        @endif
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-bell fa-fw"></i>
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="container-fluid">
                @yield('content')
            </div>

        </div>

        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>© UMKM App {{ date('Y') }}</span>
                </div>
            </div>
        </footer>

    </div>

</div>

<script src="{{ asset('assets-admin/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets-admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets-admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('assets-admin/js/sb-admin-2.min.js') }}"></script>

@stack('scripts')

@if(auth()->check())
<!-- Cart Modal -->
<div class="modal fade" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="cartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cartModalLabel">Keranjang Belanja</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="cart-items">
                    <!-- Cart items will be populated here -->
                </div>
                <div id="cart-total" style="display: none;">
                    <hr>
                    <div class="row">
                        <div class="col-6">
                            <h5>Total:</h5>
                        </div>
                        <div class="col-6 text-right">
                            <h5 id="total-price">Rp 0</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="checkout-btn" style="display: none;" onclick="checkoutSelected()">Beli</button>
            </div>
        </div>
    </div>
</div>
@endif
</body>
</html>
