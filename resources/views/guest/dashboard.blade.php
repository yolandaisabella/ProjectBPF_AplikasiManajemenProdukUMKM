@extends('layouts.app')
t
@section('content')
    <div class="container-fluid">

        <!-- Authentication Section -->
        @guest
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <h5 class="card-title">Silakan login atau daftar akun.</h5>
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('login') }}" class="btn btn-primary me-3">
                                    Login
                                </a>
                                <a href="{{ route('register') }}" class="btn btn-success">
                                    Daftar Akun
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endguest

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">Selamat Datang di UMKM Kopi Kami</h1>
                <p class="mb-0">Nikmati berbagai jenis kopi berkualitas dari berbagai daerah Indonesia</p>
            </div>
            <div class="d-flex">
                <img src="{{ asset('assets-admin/img/kopi espresso.jpg') }}" alt="Kopi Espresso" class="img-fluid mr-2" style="max-height: 100px;">
                <img src="{{ asset('assets-admin/img/americano.png') }}" alt="Kopi Americano" class="img-fluid" style="max-height: 100px;">
            </div>
        </div>

        <!-- Featured Coffee -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Kopi Unggulan</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @forelse($featuredProducts as $product)
                                <div class="col-xl-4 col-md-6 mb-4">
                                    <div class="card h-100">
                                        <div class="card-img-top" style="height: 200px; overflow: hidden;">
                                            @if($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid" style="width: 100%; height: 100%; object-fit: cover;" alt="{{ $product->name }}">
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
                                            <p class="card-text"><strong>Price: Rp
                                                    {{ number_format($product->price, 0, ',', '.') }}</strong></p>
                                            <p class="card-text">Stock: {{ $product->stock }}</p>
                                            <a href="{{ route('guest.products.index') }}"
                                                class="btn btn-primary">View Details</a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <p class="text-center">No products available at the moment.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
