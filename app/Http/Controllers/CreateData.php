<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LaporanKasusPpa;
use Illuminate\Http\Request;

class CreateData extends Controller
{
    public function index()
    {
        return view('create_data');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_kasus_masuk' => 'required|date',
            'pelapor'            => 'required|string',
            'user_number'        => 'nullable|string|max:20',
            'nama_korban'        => 'nullable|string|max:255',
            'gender_korban'      => 'required|in:Laki-laki,Perempuan',
            'usia_korban'        => 'required|integer|min:1',
            'jenis_kasus'        => 'required|string',
            'tanggal_kejadian'   => 'required|date',
            'kecamatan'          => 'required|string',
            'lokasi_spesifik'    => 'required|string',
            'disabilitas_korban' => 'required|in:Ya,Tidak',
            'nama_pelaku'        => 'nullable|string|max:255',
            'gender_pelaku'      => 'nullable|in:Laki-laki,Perempuan',
            'usia_pelaku'        => 'nullable|integer|min:1',
            'hubungan_pelaku'    => 'nullable|string',
            'deskripsi_kasus'    => 'nullable|string',
            'instance'           => 'required_if:pelapor,Instansi|nullable|string|max:255',
            'address_instance'   => 'nullable|string|max:255',
        ], [
            'tanggal_kasus_masuk.required' => 'Tanggal kasus masuk wajib diisi.',
            'tanggal_kasus_masuk.date'     => 'Format tanggal kasus masuk tidak valid.',
            'pelapor.required'             => 'Pelapor wajib dipilih.',
            'user_number.required'         => 'Nomor pelapor wajib diisi.',
            'nama_korban.required'         => 'Nama korban wajib diisi.',
            'gender_korban.required'       => 'Jenis kelamin korban wajib dipilih.',
            'usia_korban.required'         => 'Usia korban wajib diisi.',
            'jenis_kasus.required'         => 'Jenis kasus wajib dipilih.',
            'tanggal_kejadian.required'    => 'Tanggal kejadian wajib diisi.',
            'kecamatan.required'           => 'Wilayah wajib dipilih.',
            'lokasi_spesifik.required'     => 'Lokasi kejadian wajib dipilih.',
            'disabilitas_korban.required'  => 'Status disabilitas wajib dipilih.',
            'instance.required_if'         => 'Nama instansi wajib diisi jika pelapor adalah Instansi.',
        ]);

        try {
            $tanggalMasuk = \Carbon\Carbon::parse($request->tanggal_kasus_masuk);

            $laporan = new LaporanKasusPpa();
            $laporan->nama_pelaku        = $request->nama_pelaku        ?? '';
            $laporan->gender_pelaku      = $request->gender_pelaku      ?? '';
            $laporan->usia_pelaku        = $request->usia_pelaku        ?? 0;
            $laporan->hubungan_pelaku    = $request->hubungan_pelaku    ?? '';
            $laporan->deskripsi_kasus    = $request->deskripsi_kasus    ?? '';
            $laporan->instance           = $request->instance           ?? '';
            $laporan->address_instance   = $request->address_instance   ?? '';
            $laporan->created_at         = $tanggalMasuk;  // simpan ke created_at
            $laporan->pelapor            = $request->pelapor;
            $laporan->user_number  = $request->user_number  ?? null;
            $laporan->nama_korban  = $request->nama_korban   ?? null;
            $laporan->gender_korban      = $request->gender_korban;
            $laporan->usia_korban        = $request->usia_korban;
            $laporan->jenis_kasus        = $request->jenis_kasus;
            $laporan->tanggal_kejadian   = $request->tanggal_kejadian;
            $laporan->kecamatan          = $request->kecamatan;
            $laporan->lokasi_spesifik    = $request->lokasi_spesifik;
            $laporan->disabilitas_korban = $request->disabilitas_korban;           
            $laporan->status             = false;
            $laporan->status_kirim       = false;

            $laporan->save();

            // Generate ID kasus menggunakan created_at yang sudah diisi manual
            $laporan->id_kasus = LaporanKasusPpa::generateIdKasus(
                $request->gender_korban,
                (int) $request->usia_korban,
                $request->pelapor,
                $tanggalMasuk
            );
            $laporan->save();

            return redirect('/pelaporan')->with('success', 'Data laporan berhasil ditambahkan.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }
}