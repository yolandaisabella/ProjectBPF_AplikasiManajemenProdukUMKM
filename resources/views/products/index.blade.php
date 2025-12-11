@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Produk UMKM</h1>
        <a href="{{ route('products.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Produk Baru
        </a>
    </div>

    <!-- Filter and Search -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter & Cari Produk</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('products.index') }}" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama produk..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="category" class="form-control">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="stock_filter" class="form-control">
                        <option value="">Semua Stok</option>
                        <option value="low_stock" {{ request('stock_filter') == 'low_stock' ? 'selected' : '' }}>Stok Rendah (< 10)</option>
                        <option value="out_of_stock" {{ request('stock_filter') == 'out_of_stock' ? 'selected' : '' }}>Stok Habis</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-search"></i> Cari
                    </button>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Products Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Produk ({{ $products->total() }} produk)</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Export:</div>
                    <a class="dropdown-item" href="#">
                        <i class="fas fa-file-csv fa-sm fa-fw mr-2 text-gray-400"></i> CSV
                    </a>
                    <a class="dropdown-item" href="#">
                        <i class="fas fa-file-excel fa-sm fa-fw mr-2 text-gray-400"></i> Excel
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if($products->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Gambar</th>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td>
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $product->name }}</strong>
                                    @if($product->description)
                                        <br><small class="text-muted">{{ Str::limit($product->description, 50) }}</small>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-info">{{ $product->category }}</span>
                                </td>
                                <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge {{ $product->stock == 0 ? 'badge-danger' : ($product->stock < 10 ? 'badge-warning' : 'badge-success') }}">
                                        {{ $product->stock }}
                                    </span>
                                </td>
                                <td>
                                    @if($product->stock == 0)
                                        <span class="badge badge-danger">Habis</span>
                                    @elseif($product->stock < 10)
                                        <span class="badge badge-warning">Stok Rendah</span>
                                    @else
                                        <span class="badge badge-success">Tersedia</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-box-open fa-4x text-gray-300 mb-4"></i>
                    <h4 class="text-gray-500">Tidak ada produk ditemukan</h4>
                    <p class="text-gray-400 mb-4">
                        @if(request()->hasAny(['search', 'category', 'stock_filter']))
                            Tidak ada produk yang sesuai dengan filter yang dipilih.
                        @else
                            Belum ada produk yang ditambahkan ke sistem.
                        @endif
                    </p>
                    <a href="{{ route('products.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Produk Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<style>
.card {
    border: none;
    border-radius: 0.35rem;
}
.card-header {
    background-color: #f8f9fc;
    border-bottom: 1px solid #e3e6f0;
}
.table th {
    border-top: none;
    font-weight: 600;
    background-color: #f8f9fc;
}
.btn-group .btn {
    margin-right: 2px;
}
.badge {
    font-size: 0.75em;
}
.img-thumbnail {
    border-radius: 0.25rem;
}
</style>
@endpush

@push('scripts')
<script>
    // Add any product-specific JavaScript here
    console.log('Products index page loaded');
</script>
@endpush
