<?php

 namespace App\Http\Controllers;
 use App\Http\Controllers\Controller;
use App\Models\LaporanKasusPpa;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DetailLaporan extends Controller
{
    /**
     * Show the profile for a given user.
     */
   public function index(Request $request, $id)
    {
        $data = LaporanKasusPpa::where('id', $id)->firstOrFail();
        return view('detail_laporan', compact('data'));
    }

    public function save(Request $request, $id)
    {
        $request->validate([
            'pelapor'           => 'string',
            'user_number'       => 'string|max:20',
            'jenis_kasus'       => 'string',
            'usia_korban'       => 'integer|min:1',
            'hubungan_pelaku'   => 'string',
            'nama_korban'       => 'string|max:255',
            'nama_pelaku'       => 'string|max:255',
            'gender_korban'     => 'in:Laki-laki,Perempuan',
            'gender_pelaku'     => 'in:Laki-laki,Perempuan',
            'usia_pelaku'       => 'integer|min:1',
            'tanggal_kejadian'  => 'date',
            'deskripsi_kasus'   => 'string',
            'kecamatan'         => 'string',
            'lokasi_spesifik'   => 'string',
            'disabilitas_korban'=> 'in:Ya,Tidak',
            'status'            => 'in:0,1',
            'validasi'          => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ], [
            'pelapor.required'          => 'Pelapor wajib dipilih.',
            'user_number.required'      => 'Nomor pelapor wajib diisi.',
            'jenis_kasus.required'      => 'Jenis kasus wajib dipilih.',
            'usia_korban.required'      => 'Usia korban wajib diisi.',
            'usia_korban.integer'       => 'Usia korban harus berupa angka.',
            'hubungan_pelaku.required'  => 'Hubungan pelaku wajib dipilih.',
            'nama_korban.required'      => 'Nama korban wajib diisi.',
            'nama_pelaku.required'      => 'Nama pelaku wajib diisi.',
            'gender_korban.required'    => 'Jenis kelamin korban wajib dipilih.',
            'gender_pelaku.required'    => 'Jenis kelamin pelaku wajib dipilih.',
            'usia_pelaku.required'      => 'Usia pelaku wajib diisi.',
            'usia_pelaku.integer'       => 'Usia pelaku harus berupa angka.',
            'tanggal_kejadian.required' => 'Tanggal kejadian wajib diisi.',
            'tanggal_kejadian.date'     => 'Format tanggal kejadian tidak valid.',
            'deskripsi_kasus.required'  => 'Deskripsi kasus wajib diisi.',
            'kecamatan.required'        => 'Wilayah wajib dipilih.',
            'lokasi_spesifik.required'  => 'Lokasi kejadian wajib dipilih.',
            'disabilitas_korban.required' => 'Status disabilitas korban wajib dipilih.',
            'status.required'           => 'Status kasus wajib dipilih.',
            'validasi.mimes'            => 'File validasi harus berformat pdf, jpg, atau png.',
            'validasi.max'              => 'Ukuran file maksimal 2MB.',
        ]);

        try {
            $laporan = LaporanKasusPpa::findOrFail($id);

            $laporan->pelapor           = $request->pelapor;
            $laporan->user_number       = $request->user_number;
            $laporan->jenis_kasus       = $request->jenis_kasus;
            $laporan->usia_korban       = $request->usia_korban;
            $laporan->hubungan_pelaku   = $request->hubungan_pelaku;
            $laporan->nama_korban       = $request->nama_korban;
            $laporan->nama_pelaku       = $request->nama_pelaku;
            $laporan->gender_korban     = $request->gender_korban;
            $laporan->gender_pelaku     = $request->gender_pelaku;
            $laporan->usia_pelaku       = $request->usia_pelaku;
            $laporan->tanggal_kejadian  = $request->tanggal_kejadian;
            $laporan->deskripsi_kasus   = $request->deskripsi_kasus;
            $laporan->kecamatan         = $request->kecamatan;
            $laporan->lokasi_spesifik   = $request->lokasi_spesifik;
            $laporan->disabilitas_korban = $request->disabilitas_korban;
            $laporan->status            = $request->status;

            // Jika ada file validasi baru diupload, otomatis set status selesai
            if ($request->hasFile('validasi')) {
                $file     = $request->file('validasi');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/validasi'), $filename);
                $laporan->validasi = $filename;
                $laporan->status   = true; // otomatis selesai
            } else {
                // Jika tidak upload file baru, ikuti pilihan status dari form
                // tapi jika belum pernah ada validasi, paksa Dalam Proses
                if (!$laporan->validasi) {
                    $laporan->status = false;
                } else {
                    $laporan->status = $request->status;
                }
            }

           // Generate & simpan ID Kasus
            $laporan->id_kasus = \App\Models\LaporanKasusPpa::generateIdKasus(
                $request->gender_korban,
                (int) $request->usia_korban,
                $request->pelapor,
                $laporan->created_at
            );

            $laporan->save();

            return redirect()->back()->with('success', 'Data berhasil disimpan.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
            
        }
    }
    public function destroy($id)
    {
        try {
            $laporan = LaporanKasusPpa::findOrFail($id);
            $laporan->delete(); // soft delete — hanya mengisi deleted_at
            return redirect('/pelaporan')->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }
}
