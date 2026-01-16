@extends('layouts.guest')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Item</h1>
    </div>

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('guest.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Item</li>
        </ol>
    </nav>

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Item Tersedia</h6>
                </div>
                <div class="card-body">
                    @if($items->count() > 0)
                        <div class="row">
                            @foreach($items as $item)
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-img-top" style="height: 200px; overflow: hidden;">
                                        @if($item->image)
                                            <img src="{{ asset('storage/' . $item->image) }}" class="img-fluid" style="width: 100%; height: 100%; object-fit: cover;" alt="{{ $item->name }}">
                                        @else
                                            <img src="{{ asset('assets-admin/img/kopi espresso.jpg') }}" class="img-fluid" style="width: 100%; height: 100%; object-fit: cover;" alt="{{ $item->name }}">
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $item->name }}</h5>
                                        <p class="card-text">Harga: Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                        <p class="card-text">Stok: {{ $item->stock }}</p>
                                        <p class="card-text">
                                            @if($item->stock == 0)
                                                <span class="badge badge-danger">Habis</span>
                                            @elseif($item->stock < 10)
                                                <span class="badge badge-warning">Stok Rendah</span>
                                            @else
                                                <span class="badge badge-success">Tersedia</span>
                                            @endif
                                        </p>
                                        <a href="{{ route('guest.items.show', $item) }}" class="btn btn-primary btn-block">Beli</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="d-flex justify-content-center">
                            {{ $items->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-box-open fa-4x text-gray-300 mb-4"></i>
                            <h4 class="text-gray-500 mb-3">Belum ada item tersedia</h4>
                            <p class="text-gray-500 mb-4">Saat ini tidak ada item yang tersedia untuk ditampilkan.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
