@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Produk</h1>
        <a href="{{ route('products.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Produk Baru
        </a>
    </div>

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Produk</li>
        </ol>
    </nav>

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Produk</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Aksi:</div>
                            <a class="dropdown-item" href="{{ route('products.create') }}">
                                <i class="fas fa-plus fa-sm fa-fw mr-2 text-gray-400"></i>Tambah Produk
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-download fa-sm fa-fw mr-2 text-gray-400"></i>Export Data
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
                                                <div class="bg-light d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; border-radius: 0.25rem;">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{ $product->name }}</td>
                                        <td>
                                            <span class="badge badge-info">{{ $product->category }}</span>
                                        </td>
                                        <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                        <td>{{ $product->stock }}</td>
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
                                                <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-info" title="Lihat">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger" title="Hapus" onclick="confirmDelete({{ $product->id }}, '{{ $product->name }}')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {{ $products->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-box-open fa-4x text-gray-300 mb-4"></i>
                            <h4 class="text-gray-500 mb-3">Belum ada produk</h4>
                            <p class="text-gray-500 mb-4">Mulai tambahkan produk pertama Anda untuk mengelola inventaris UMKM.</p>
                            <a href="{{ route('products.create') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-plus fa-sm text-white-50 mr-2"></i>Tambah Produk Pertama
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus produk "<strong id="productName"></strong>"?</p>
                <p class="text-danger small">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form id="deleteForm" action="" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus Produk</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.table th {
    border-top: none;
    font-weight: 600;
}
.badge {
    font-size: 0.75rem;
}
.btn-group .btn {
    margin-right: 2px;
}
</style>
@endpush

@push('scripts')
<script src="{{ asset('assets-admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets-admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets-admin/js/demo/datatables-demo.js') }}"></script>
<script>
function confirmDelete(productId, productName) {
    document.getElementById('productName').textContent = productName;
    document.getElementById('deleteForm').action = '{{ url("products") }}/' + productId;
    $('#deleteModal').modal('show');
}
</script>
@endpush
