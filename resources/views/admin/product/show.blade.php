@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Produk</h1>
        <div>
            <a href="{{ route('admin.product.edit', $product) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('admin.product.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.product.index') }}">Produk</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Produk</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded mb-3" alt="{{ $product->name }}">
                            @else
                                <img src="{{ asset('assets-admin/img/kopi espresso.jpg') }}" class="img-fluid rounded mb-3" alt="{{ $product->name }}">
                            @endif
                        </div>
                        <div class="col-md-8">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">
                                <strong>Harga:</strong> Rp {{ number_format($product->price, 0, ',', '.') }}
                            </p>
                            <p class="card-text">
                                <strong>Stok:</strong>
                                @if($product->stock > 10)
                                    <span class="badge badge-success">{{ $product->stock }}</span>
                                @elseif($product->stock > 0)
                                    <span class="badge badge-warning">{{ $product->stock }}</span>
                                @else
                                    <span class="badge badge-danger">{{ $product->stock }}</span>
                                @endif
                            </p>
                            <p class="card-text">
                                <strong>Kategori:</strong> {{ $product->category ?? 'Tidak ada kategori' }}
                            </p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <strong>Deskripsi:</strong>
                            <p class="mt-2">{{ $product->description ?? 'Tidak ada deskripsi' }}</p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <p class="card-text">
                                <strong>Dibuat:</strong> {{ $product->created_at->format('d M Y H:i') }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="card-text">
                                <strong>Diupdate:</strong> {{ $product->updated_at->format('d M Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Aksi</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.product.edit', $product) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Produk
                        </a>
                        <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                            <i class="fas fa-trash"></i> Hapus Produk
                        </button>
                    </div>
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
                <p>Apakah Anda yakin ingin menghapus produk "<strong>{{ $product->name }}</strong>"?</p>
                <p class="text-danger small">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form action="{{ route('admin.product.destroy', $product) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus Produk</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete() {
    $('#deleteModal').modal('show');
}
</script>
