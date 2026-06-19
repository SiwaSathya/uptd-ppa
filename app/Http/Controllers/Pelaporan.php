<?php

 namespace App\Http\Controllers;
 use App\Http\Controllers\Controller;
 use App\Models\LaporanKasusPpa;
 use Illuminate\View\View;

class Pelaporan extends Controller
{
    /**
     * Show the profile for a given user.
     */
    public function index()
    {
        $data = LaporanKasusPpa::get();
        return view('pelaporan', compact('data'));
    }
}
