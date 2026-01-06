<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function products()
    {
        return view('guest.access_denied');
    }

    public function users()
    {
        return view('guest.access_denied');
    }

    public function reports()
    {
        return view('guest.access_denied');
    }
}
