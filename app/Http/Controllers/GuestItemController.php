<?php

namespace App\Http\Controllers;

use App\Models\Item;

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
}
