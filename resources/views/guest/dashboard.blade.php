@extends('layouts.guest')
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
                <h1 class="h3 mb-0 text-gray-800">Selamat Datang di UMKM Kami</h1>
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
                                                @auth
                                                    <form id="purchase-form-{{ $product->id }}" action="{{ route('guest.products.purchase', $product) }}" method="POST" style="display: none;">
                                                        @csrf
                                                        <input type="hidden" name="quantity" value="1">
                                                    </form>
                                                    <div class="row mt-3">
                                                        <div class="col-6">
                                                            <button type="button" class="btn btn-outline-primary btn-block" onclick="addToCart({{ $product->id }}, 1)">
                                                                <i class="fas fa-cart-plus"></i> Keranjang
                                                            </button>
                                                        </div>
                                                        <div class="col-6">
                                                            <button type="button" class="btn btn-primary btn-block" onclick="purchaseProduct({{ $product->id }}, '{{ $product->name }}')">
                                                                <i class="fas fa-shopping-bag"></i> Beli
                                                            </button>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="alert alert-warning mt-3" role="alert">
                                                        <small>Silakan <a href="{{ route('login') }}">login</a> untuk membeli produk ini.</small>
                                                    </div>
                                                @endauth
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

    function formatPrice(price) {
        let formatted = price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        return formatted.replace(/\.00$/, '');
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
                    <div class="col-1">
                        <input type="checkbox" class="cart-item-checkbox" value="${item.id}" onchange="updateTotal()">
                    </div>
                    <div class="col-3">
                        <img src="${item.image ? '/storage/' + item.image : '/assets-admin/img/kopi espresso.jpg'}" class="img-fluid rounded" alt="${item.name}">
                    </div>
                    <div class="col-4">
                        <h6>${item.name}</h6>
                        <p class="mb-1">Rp ${formatPrice(item.price)}</p>
                        <div class="d-flex align-items-center">
                            <button class="btn btn-sm btn-outline-secondary" onclick="changeQuantity(${item.id}, -1)">-</button>
                            <span class="mx-2">Jumlah: ${item.quantity}</span>
                            <button class="btn btn-sm btn-outline-secondary" onclick="changeQuantity(${item.id}, 1)">+</button>
                        </div>
                    </div>
                    <div class="col-4 text-right">
                        <p class="mb-0"><strong>Rp ${formatPrice(itemTotal)}</strong></p>
                        <button class="btn btn-sm btn-danger" onclick="removeFromCart(${item.id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;
        });

        cartItems.innerHTML = itemsHtml;
        document.getElementById('total-price').textContent = 'Rp ' + formatPrice(total);
        cartTotal.style.display = 'block';
        checkoutBtn.style.display = 'block';
    }

    function changeQuantity(productId, delta) {
        const item = cart.find(item => item.id === productId);
        if (item) {
            item.quantity += delta;
            if (item.quantity <= 0) {
                removeFromCart(productId);
                return;
            }
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartCounter();
            updateCartModal();
        }
    }

    function removeFromCart(productId) {
        cart = cart.filter(item => item.id !== productId);
        localStorage.setItem('cart', JSON.stringify(cart));
        updateCartCounter();
        updateCartModal();
    }

    function updateTotal() {
        const checkboxes = document.querySelectorAll('.cart-item-checkbox:checked');
        let selectedTotal = 0;

        checkboxes.forEach(checkbox => {
            const itemId = parseInt(checkbox.value);
            const item = cart.find(item => item.id === itemId);
            if (item) {
                selectedTotal += item.price * item.quantity;
            }
        });

        const totalPriceElement = document.getElementById('total-price');
        if (totalPriceElement) {
            totalPriceElement.textContent = 'Rp ' + selectedTotal.toLocaleString('id-ID');
        }

        const cartTotal = document.getElementById('cart-total');
        if (cartTotal) {
            cartTotal.style.display = checkboxes.length > 0 ? 'block' : 'none';
        }

        const checkoutBtn = document.getElementById('checkout-btn');
        if (checkoutBtn) {
            checkoutBtn.style.display = checkboxes.length > 0 ? 'inline-block' : 'none';
        }
    }

    function checkoutSelected() {
        const checkboxes = document.querySelectorAll('.cart-item-checkbox:checked');
        const selectedItems = [];

        checkboxes.forEach(checkbox => {
            const itemId = parseInt(checkbox.value);
            const item = cart.find(item => item.id === itemId);
            if (item) {
                selectedItems.push({
                    id: item.id,
                    quantity: item.quantity
                });
            }
        });

        if (selectedItems.length === 0) {
            alert('Pilih produk yang ingin dibeli terlebih dahulu.');
            return;
        }

        // Create form to submit checkout
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("guest.products.checkout") }}';
        form.style.display = 'none';

        // Add CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);

        // Add selected items
        selectedItems.forEach((item, index) => {
            const idInput = document.createElement('input');
            idInput.type = 'hidden';
            idInput.name = `items[${index}][id]`;
            idInput.value = item.id;
            form.appendChild(idInput);

            const qtyInput = document.createElement('input');
            qtyInput.type = 'hidden';
            qtyInput.name = `items[${index}][quantity]`;
            qtyInput.value = item.quantity;
            form.appendChild(qtyInput);
        });

        document.body.appendChild(form);
        form.submit();
    }

    function purchaseProduct(productId, productName) {
        alert('Pesanan berhasil, tunggu pesanan anda siap');
        document.getElementById('purchase-form-' + productId).submit();
    }

    // Initialize cart on page load
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('cart_cleared'))
            // Clear cart if checkout was successful
            cart = [];
            localStorage.setItem('cart', JSON.stringify(cart));
        @endif
        updateCartCounter();
        updateCartModal();
    });
</script>
@endpush
