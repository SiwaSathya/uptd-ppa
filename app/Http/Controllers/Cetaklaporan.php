<?php

namespace App\Http\Controllers;

use App\Models\LaporanKasusPpa;

class CetakLaporan extends Controller
{
    public function index()
    {
        $data = LaporanKasusPpa::select(
            'jenis_kasus', 'tanggal_kejadian',
            'usia_korban', 'gender_korban'
        )->get();

        return view('cetak_laporan', compact('data'));
    }
}