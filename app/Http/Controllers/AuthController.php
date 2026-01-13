<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function loginProcess(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('username', 'password'))) {

            if (Auth::user()->role === 'admin') {
                return redirect('/admin/dashboard');
            } elseif (Auth::user()->role === 'staff') {
                return redirect('/staff/dashboard');
            } else {
                return redirect('/guest/dashboard');
            }

        }

        return back()->with('error', 'Username atau password salah');
    }

    public function logoutConfirm()
    {
        return view('auth.logout_confirm');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function registerStaff()
    {
        return view('auth.register_staff');
    }

    public function registerStaffProcess(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'staff',
        ]);

        Auth::login($user);

        return redirect('/staff/dashboard');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function registerProcess(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'guest',
        ]);

        Auth::login($user);

        if ($user->role === 'admin') {
            return redirect('/admin/dashboard');
        } elseif ($user->role === 'staff') {
            return redirect('/staff/dashboard');
        } else {
            return redirect('/guest/dashboard');
        }
    }
}

