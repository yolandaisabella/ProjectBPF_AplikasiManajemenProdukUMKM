<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
    <div class="sidebar-brand-icon">
        <i class="fas fa-store"></i>
    </div>
    <div class="sidebar-brand-text mx-3">UMKM</div>
</a>

<hr class="sidebar-divider my-0">

<li class="nav-item">
    <a class="nav-link" href="{{ route('dashboard') }}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span>
    </a>
</li>

<hr class="sidebar-divider">

<div class="sidebar-heading">
    Menu
</div>

<li class="nav-item">
    <a class="nav-link" href="{{ route('products.index') }}">
        <i class="fas fa-box"></i>
        <span>Produk</span>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link" href="#">
        <i class="fas fa-users"></i>
        <span>Pelanggan</span>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link" href="#">
        <i class="fas fa-chart-line"></i>
        <span>Laporan</span>
    </a>
</li>

</ul>
