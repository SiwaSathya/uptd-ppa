<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class pLogout extends Controller
{
    public function index(Request $request)
    {
        Auth::logout();

        // ── Simpan alert DULU sebelum session diinvalidate ──
        Alert::success('Logout', 'Berhasil keluar.');

        $request->session()->invalidate();      // hapus semua data session
        $request->session()->regenerateToken(); // regenerate CSRF token

        return redirect('/');
    }
}