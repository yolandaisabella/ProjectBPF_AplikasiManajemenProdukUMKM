@extends('layouts.guest')
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
                                            <p class="card-text"><strong>Harga: Rp {{ number_format($product->price, 0, ',', '.') }}</strong></p>
                                            <p class="card-text">Stok: {{ $product->stock }}</p>
                                            @if($product->stock > 0)
                                                <div class="row mt-3">
                                                    <div class="col-6">
                                                        <button type="button" class="btn btn-outline-primary btn-block" onclick="addToCart({{ $product->id }}, 1)">
                                                            <i class="fas fa-cart-plus"></i> Keranjang
                                                        </button>
                                                    </div>
                                                    <div class="col-6">
                                                        <form action="{{ route('guest.products.purchase', $product) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <input type="hidden" name="quantity" value="1">
                                                            <button type="submit" class="btn btn-primary btn-block">
                                                                <i class="fas fa-shopping-bag"></i> Beli
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="alert alert-danger mt-3" role="alert">
                                                    Habis Stok
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <p class="text-center">Tidak ada produk tersedia saat ini.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
<script>
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    const products = @json($featuredProducts);

    function addToCart(productId, quantity) {
        const product = products.find(p => p.id === productId);
        const existingItem = cart.find(item => item.id === productId);

        if (existingItem) {
            existingItem.quantity += quantity;
        } else {
            cart.push({
                id: product.id,
                name: product.name,
                price: product.price,
                image: product.image,
                quantity: quantity
            });
        }

        localStorage.setItem('cart', JSON.stringify(cart));
        updateCartCounter();
        updateCartModal();

        alert('Item ditambahkan ke keranjang: ' + quantity + ' buah');
    }

    function updateCartCounter() {
        const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
        const counter = document.getElementById('cart-counter');

        if (totalItems > 0) {
            counter.textContent = totalItems;
            counter.style.display = 'inline';
        } else {
            counter.style.display = 'none';
        }
    }

    function updateCartModal() {
        const cartItems = document.getElementById('cart-items');
        const cartTotal = document.getElementById('cart-total');
        const checkoutBtn = document.getElementById('checkout-btn');

        if (cart.length === 0) {
            cartItems.innerHTML = '<p class="text-center">Keranjang kosong</p>';
            cartTotal.style.display = 'none';
            checkoutBtn.style.display = 'none';
            return;
        }

        let itemsHtml = '';
        let total = 0;

        cart.forEach(item => {
            const itemTotal = item.price * item.quantity;
            total += itemTotal;

            itemsHtml += `
                <div class="row mb-3 align-items-center">
                    <div class="col-3">
                        <img src="${item.image ? '/storage/' + item.image : '/assets-admin/img/kopi espresso.jpg'}" class="img-fluid rounded" alt="${item.name}">
                    </div>
                    <div class="col-6">
                        <h6>${item.name}</h6>
                        <p class="mb-1">Rp ${item.price.toLocaleString('id-ID')}</p>
                        <p class="mb-0">Jumlah: ${item.quantity}</p>
                    </div>
                    <div class="col-3 text-right">
                        <p class="mb-0"><strong>Rp ${itemTotal.toLocaleString('id-ID')}</strong></p>
                        <button class="btn btn-sm btn-danger" onclick="removeFromCart(${item.id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;
        });

        cartItems.innerHTML = itemsHtml;
        document.getElementById('total-price').textContent = 'Rp ' + total.toLocaleString('id-ID');
        cartTotal.style.display = 'block';
        checkoutBtn.style.display = 'block';
    }

    function removeFromCart(productId) {
        cart = cart.filter(item => item.id !== productId);
        localStorage.setItem('cart', JSON.stringify(cart));
        updateCartCounter();
        updateCartModal();
    }

    // Initialize cart on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateCartCounter();
        updateCartModal();
    });
</script>
@endpush
