<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class pLogin extends Controller
{
    public function index()
    {
        // Kalau sudah login, langsung ke dashboard
        if (Auth::check()) {
            return redirect('/dashboard');
        }
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // cegah session fixation attack
            Alert::success('Login', 'Berhasil masuk!');
            return redirect('/dashboard');
        }

        Alert::error('Gagal', 'Email atau password salah.');
        return redirect()->back()->withInput($request->only('email'));
    }
}