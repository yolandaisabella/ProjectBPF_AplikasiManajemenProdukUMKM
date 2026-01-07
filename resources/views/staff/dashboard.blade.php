@extends('layouts.app')

@section('content')
<div class="container-fluid">gimana cara

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <div class="d-flex">
            <img src="{{ asset('assets-admin/img/kopi espresso.jpg') }}" alt="Kopi Espresso" class="img-fluid mr-2" style="max-height: 100px;">
            <img src="{{ asset('assets-admin/img/americano.png') }}" alt="Kopi Americano" class="img-fluid" style="max-height: 100px;">
        </div>
    </div>

    <!-- Error Modal -->
    @if(session('error'))
    <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="errorModalLabel">Akses Ditolak</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ session('error') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
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
                            <p class="text-gray-500 mb-4">Produk akan ditampilkan di sini setelah ditambahkan.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
@if(session('error'))
<script>
    $(document).ready(function() {
        $('#errorModal').modal('show');
    });
</script>
@endif
@endpush
