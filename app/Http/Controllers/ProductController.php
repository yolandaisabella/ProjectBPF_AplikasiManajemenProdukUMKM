<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(10);
        return view('admin.product.index', compact('products'));
    }

    public function create()
    {
        return view('admin.product.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ];

        if ($request->hasFile('image')) {
            $rules['image'] = 'image|mimes:jpeg,png,jpg,gif|max:2048';
        }

        $request->validate($rules, [
            'image.image' => 'File yang dipilih harus berupa gambar.',
            'image.mimes' => 'Gambar harus berformat jpeg, png, jpg, atau gif.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $data['image'] = $imagePath;
        }

        Product::create($data);

        return redirect()->route('admin.dashboard')->with('success', 'Produk berhasil ditambahkan dan muncul di dashboard');
    }

    public function edit(Product $product)
    {
        return view('admin.product.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ];

        if ($request->hasFile('image')) {
            $rules['image'] = 'image|mimes:jpeg,png,jpg,gif|max:2048';
        }

        $request->validate($rules, [
            'image.image' => 'File yang dipilih harus berupa gambar.',
            'image.mimes' => 'Gambar harus berformat jpeg, png, jpg, atau gif.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $data['image'] = $imagePath;
        }

        $product->update($data);
        return redirect()->route('admin.product.index')->with('success', 'Produk berhasil diupdate');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success', 'Produk berhasil dihapus');
    }

    public function show(Product $product)
    {
        return view('admin.product.show', compact('product'));
    }

    public function purchase(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->stock,
        ]);

        $product->stock -= $request->quantity;
        $product->save();

        return redirect()->back()->with('success', 'Pembelian berhasil! Produk: ' . $product->name . ', Jumlah: ' . $request->quantity);
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|integer|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $items = $request->items;
        $errors = [];

        // Check stock for all items first
        foreach ($items as $itemData) {
            $product = Product::find($itemData['id']);
            if ($product->stock < $itemData['quantity']) {
                $errors[] = 'Stok ' . $product->name . ' tidak mencukupi. Stok tersedia: ' . $product->stock;
            }
        }

        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors);
        }

        // Reduce stock for all items
        foreach ($items as $itemData) {
            $product = Product::find($itemData['id']);
            $product->update(['stock' => $product->stock - $itemData['quantity']]);
        }

        session(['cart_cleared' => true]);

        return redirect()->back()->with('success', 'Checkout berhasil! Pesanan akan segera diproses.');
    }
}
