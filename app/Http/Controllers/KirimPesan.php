<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LaporanKasusPpa;
use Illuminate\Http\Request;

class KirimPesan extends Controller
{
    public function index($id)
    {
        $data = LaporanKasusPpa::findOrFail($id);
        return view('kirim_pesan', compact('data'));
    }

    public function send(Request $request, $id)
    {
        $request->validate([
            'tanggal_pertemuan' => 'required|date',
            'waktu_jam'         => 'required|integer|between:1,12',
            'waktu_menit'       => 'required|integer|between:0,59',
            'waktu_ampm'        => 'required|in:AM,PM',
        ], [
            'tanggal_pertemuan.required' => 'Tanggal pertemuan wajib diisi.',
            'tanggal_pertemuan.date'     => 'Format tanggal tidak valid.',
            'waktu_jam.required'         => 'Jam pertemuan wajib diisi.',
            'waktu_menit.required'       => 'Menit pertemuan wajib diisi.',
            'waktu_ampm.required'        => 'AM/PM wajib dipilih.',
        ]);

        try {
            $data = LaporanKasusPpa::findOrFail($id);

            $jam   = str_pad($request->waktu_jam, 2, '0', STR_PAD_LEFT);
            $menit = str_pad($request->waktu_menit, 2, '0', STR_PAD_LEFT);
            $waktu = $jam . ':' . $menit . ' ' . $request->waktu_ampm;

            $tanggalFormatted = \Carbon\Carbon::parse($request->tanggal_pertemuan)
                                    ->translatedFormat('l, d F Y');

            // Simpan ke database
            $data->tanggal_pertemuan = $request->tanggal_pertemuan;
            $data->waktu_pertemuan   = $waktu;
            $data->status_kirim      = true;
            $data->save();

            // Format pesan WhatsApp
            $pesan = "Yth. {$data->nama_korban},\n\n"
                . "Kami dari UPTD PPA Karangasem ingin menginformasikan jadwal pertemuan terkait kasus Anda.\n\n"
                . "Anda bisa datang langsung ke kantor UPTD PPA di Jalan Ngurah Rai No. 70 Amlapura "
                . "pada waktu {$tanggalFormatted}, pukul {$waktu}.\n\n"
                . "Terima kasih telah mau melaporkan kasus Anda. "
                . "Kami siap membantu dan mendampingi Anda.\n\n"
                . "Hormat kami,\n"
                . "UPTD Perlindungan Perempuan dan Anak\n"
                . "Kabupaten Karangasem";

            $nomorWa  = preg_replace('/^0/', '62', $data->user_number);
            $nomorWa  = preg_replace('/^\+/', '', $nomorWa);
            $pesanEnc = urlencode($pesan);
            $waUrl    = "https://wa.me/{$nomorWa}?text={$pesanEnc}";

            return redirect()->back()->with([
                'success' => 'Jadwal berhasil disimpan. Silakan kirim pesan via WhatsApp.',
                'wa_url'  => $waUrl,
            ]);

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }
}