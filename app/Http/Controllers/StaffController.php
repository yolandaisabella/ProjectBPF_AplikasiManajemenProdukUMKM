<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function users()
    {
        return view('guest.access_denied');
    }

    public function reports()
    {
        return view('guest.access_denied');
    }
}
