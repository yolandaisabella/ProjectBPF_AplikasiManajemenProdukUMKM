@extends('layouts.app')

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Produk UMKM</h1> <a href="{{ route('products.create') }}"
            class="btn btn-sm btn-primary shadow-sm"> <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Produk Baru </a>
    </div>

    {{-- FILTER --}}

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter & Cari Produk</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('products.index') }}" class="row">
                <div class="col-md-4 mb-2">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama produk"
                        value="{{ request('search') }}">
                </div>

                <div class="col-md-3 mb-2">
                    <select name="category" class="form-control">
                        <option value="">Semua Kategori</option>
                        @foreach($category)
                        <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 mb-2">
                    <select name="stock_filter" class="form-control">
                        <option value="">Semua Stok</option>
                        <option value="low_stock" {{ request('stock_filter') == 'low_stock' ? 'selected' : '' }}>Stok Rendah
                            (< 10)</option>
                        <option value="out_of_stock" {{ request('stock_filter') == 'out_of_stock' ? 'selected' : '' }}>Stok
                            Habis</option>
                    </select>
                </div>

                <div class="col-md-3 mb-2 d-flex">
                    <button type="submit" class="btn btn-primary mr-2">
                        <i class="fas fa-search"></i> Cari
                    </button>

                    <a href="{{ route('products.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Reset
                    </a>
                </div>
            </form>
        </div>

    </div>

    {{-- TABLE --}}

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                Daftar Produk ({{ $products->total() }} Produk)
            </h6>

            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>

                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                    <div class="dropdown-header">Export</div>
                    <a class="dropdown-item" href="#"><i class="fas fa-file-csv fa-sm fa-fw mr-2"></i> CSV</a>
                    <a class="dropdown-item" href="#"><i class="fas fa-file-excel fa-sm fa-fw mr-2"></i> Excel</a>
                </div>
            </div>
        </div>

        <div class="card-body">
            @if ($products->count())
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="bg-light">
                            <tr>
                                <th>Gambar</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Status</th>
                                <th width="120px">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($products as $p)
                                <tr>
                                    <td>
                                        @if ($p->image)
                                            <img src="{{ asset('storage/' . $p->image) }}" class="img-thumbnail"
                                                style="width:50px; height:50px; object-fit:cover">
                                        @else
                                            <div class="bg-light text-center d-flex align-items-center justify-content-center"
                                                style="width:50px; height:50px">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        @endif
                                    </td>

                                    <td>
                                        <strong>{{ $p->name }}</strong><br>
                                        @if ($p->description)
                                            <small class="text-muted">{{ Str::limit($p->description, 45) }}</small>
                                        @endif
                                    </td>

                                    <td><span class="badge badge-info">{{ $p->category }}</span></td>

                                    <td>Rp {{ number_format($p->price, 0, ',', '.') }}</td>

                                    <td>
                                        <span
                                            class="badge
                            {{ $p->stock == 0 ? 'badge-danger' : ($p->stock < 10 ? 'badge-warning' : 'badge-success') }}">
                                            {{ $p->stock }}
                                        </span>
                                    </td>

                                    <td>
                                        @if ($p->stock == 0)
                                            <span class="badge badge-danger">Habis</span>
                                        @elseif($p->stock < 10)
                                            <span class="badge badge-warning">Stok Rendah</span>
                                        @else
                                            <span class="badge badge-success">Tersedia</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="{{ route('products.show', $p) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <a href="{{ route('products.edit', $p) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form action="{{ route('products.destroy', $p) }}" method="POST"
                                                onsubmit="return confirm('Hapus produk ini?')">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-sm btn-danger">
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

                <div class="d-flex justify-content-center mt-3">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-box-open fa-4x text-gray-300 mb-4"></i>
                    <h4 class="text-gray-500">Tidak ada produk</h4>

                    @if (request()->hasAny(['search', 'category', 'stock_filter']))
                        <p class="text-gray-400">Tidak ada produk sesuai filter.</p>
                    @else
                        <p class="text-gray-400">Belum ada data produk.</p>
                    @endif

                    <a href="{{ route('products.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Produk Pertama
                    </a>
                </div>
            @endif
        </div>

    </div>

@endsection

@push('styles')
    <style>
        .img-thumbnail {
            border-radius: 0.25rem;
        }

        .table th {
            font-weight: 600;
        }

        .btn-group .btn {
            margin-right: 2px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        console.log('Product index loaded');
    </script>
@endpush
