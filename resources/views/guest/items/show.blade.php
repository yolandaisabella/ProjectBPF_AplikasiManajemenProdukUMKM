d@extends('layouts.guest')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Item</h1>
    </div>

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('guest.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('guest.items.index') }}">Item</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $item->name }}</li>
        </ol>
    </nav>

    <!-- Success Modal -->
    @if(session('success'))
    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Pembelian Berhasil</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ session('success') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $item->name }}</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            @if($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}" class="img-fluid rounded" alt="{{ $item->name }}">
                            @else
                                <img src="{{ asset('assets-admin/img/kopi espresso.jpg') }}" class="img-fluid rounded" alt="{{ $item->name }}">
                            @endif
                        </div>
                        <div class="col-md-8">
                            <h5 class="card-title">{{ $item->name }}</h5>
                            <p class="card-text">{{ $item->description }}</p>
                            <p class="card-text"><strong>Harga: Rp {{ number_format($item->price, 0, ',', '.') }}</strong></p>
                            <p class="card-text">
                                <span class="text-warning">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= 4)
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </span>
                                <small class="text-muted">(4.5 dari 10 ulasan)</small>
                            </p>
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
                            @if($item->category)
                                <p class="card-text"><small class="text-muted">Kategori: {{ $item->category->name }}</small></p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Beli Item</h6>
                </div>
                <div class="card-body">
                    @if($item->stock > 0)
                        <form action="{{ route('guest.items.purchase', $item) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="quantity">Jumlah</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" min="1" max="{{ $item->stock }}" value="1" required>
                            </div>
                            <div class="form-group">
                                <label>Total Harga</label>
                                <p class="form-control-plaintext" id="total-price">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <button type="button" class="btn btn-outline-primary btn-block" onclick="addToCart({{ $item->id }}, $('#quantity').val())">
                                        <i class="fas fa-cart-plus"></i> Keranjang
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="fas fa-shopping-bag"></i> Beli
                                    </button>
                                </div>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-danger" role="alert">
                            Item ini sedang habis stok.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#quantity').on('input', function() {
            var quantity = $(this).val();
            var price = {{ $item->price }};
            var total = quantity * price;
            $('#total-price').text('Rp ' + total.toLocaleString('id-ID'));
        });
    });

    function addToCart(itemId, quantity) {
        alert('Item ditambahkan ke keranjang: ' + quantity + ' buah');
        // Here you can implement actual cart functionality
    }

    function purchaseItem() {
        alert('Pesanan berhasil, tunggu pesanan anda siap');
        // Here you can implement actual purchase functionality
    }
</script>
@endpush
