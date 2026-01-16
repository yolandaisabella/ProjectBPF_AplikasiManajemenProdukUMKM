<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class GuestItemController extends Controller
{
    public function index()
    {
        $items = Item::with('category')->get();
        return view('guest.items.index', compact('items'));
    }

    public function show(Item $item)
    {
        return view('guest.items.show', compact('item'));
    }

    public function purchasePage(Item $item)
    {
        return view('guest.items.purchase', compact('item'));
    }

    public function purchase(Request $request, Item $item)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $item->stock,
        ]);

        $item->update(['stock' => $item->stock - $request->quantity]);

        return redirect()->back()->with('success', 'Pembelian berhasil! Item: ' . $item->name . ', Jumlah: ' . $request->quantity);
    }
}
