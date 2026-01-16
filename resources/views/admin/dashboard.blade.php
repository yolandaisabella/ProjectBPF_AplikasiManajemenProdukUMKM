@extends('layouts.app')

@section('content')
    <div class="container-fluid">



        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        <!-- Latest Product Highlight -->
        @if(isset($latestProduct))
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-success">Produk Terbaru</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                @if($latestProduct->image)
                                    @if(str_starts_with($latestProduct->image, 'products/'))
                                        <img src="{{ asset('storage/' . $latestProduct->image) }}" class="img-fluid rounded" alt="{{ $latestProduct->name }}">
                                    @else
                                        <img src="{{ asset($latestProduct->image) }}" class="img-fluid rounded" alt="{{ $latestProduct->name }}">
                                    @endif
                                @endif
                            </div>
                            <div class="col-md-8">
                                <h5 class="card-title">{{ $latestProduct->name }}</h5>
                                <p class="card-text">{{ Str::limit($latestProduct->description, 200) }}</p>
                                <p class="card-text"><strong>Rp {{ number_format($latestProduct->price, 0, ',', '.') }}</strong></p>
                                <p class="card-text"><small class="text-muted">Stok: {{ $latestProduct->stock }}</small></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Featured Products Section -->
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Produk</h6>
                    </div>
                    <div class="card-body">
                        @if($featuredProducts->count() > 0)
                            <div class="row">
                                @foreach($featuredProducts as $product)
                                <div class="col-xl-4 col-md-6 mb-4">
                                    <div class="card h-100">
                                        <div class="card-img-top" style="height: 200px; overflow: hidden;">
                                            @if($product->image)
                                                @if(str_starts_with($product->image, 'products/'))
                                                    <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid" style="width: 100%; height: 100%; object-fit: cover;" alt="{{ $product->name }}">
                                                @else
                                                    <img src="{{ asset($product->image) }}" class="img-fluid" style="width: 100%; height: 100%; object-fit: cover;" alt="{{ $product->name }}">
                                                @endif
                                            @else
                                                @if(str_contains(strtolower($product->name), 'americano'))
                                                    <img src="{{ asset('assets-admin/img/americano.png') }}" class="img-fluid" style="width: 100%; height: 100%; object-fit: cover;" alt="{{ $product->name }}">
                                                @else
                                                    <img src="{{ asset('assets-admin/img/kopi espresso.jpg') }}" class="img-fluid" style="width: 100%; height: 100%; object-fit: cover;" alt="{{ $product->name }}">
                                                @endif
                                            @endif
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $product->name }}</h5>
                                            <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                                            <p class="card-text"><strong>Rp {{ number_format($product->price, 0, ',', '.') }}</strong></p>
                                            <p class="card-text"><small class="text-muted">Stok: {{ $product->stock }}</small></p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-coffee fa-4x text-gray-300 mb-4"></i>
                                <h4 class="text-gray-500 mb-3">Belum ada produk</h4>
                                <p class="text-gray-500 mb-4">Mulai tambahkan produk pertama untuk UMKM kopi Anda.</p>
                                <a href="{{ route('admin.product.create') }}" class="btn btn-primary btn-lg">
                                    <i class="fas fa-plus fa-sm text-white-50 mr-2"></i>Tambah Produk Pertama
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
