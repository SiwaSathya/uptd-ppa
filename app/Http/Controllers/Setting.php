<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use Illuminate\Http\Request;
use App\Models\JenisKasus;
use App\Models\UndangUndang;
use App\Models\Faq;
use App\Models\Sop;
use App\Models\PanduanKeamanan;
use App\Models\KepalaUptd;
use Illuminate\Support\Facades\Storage;

class Setting extends Controller
{
    
    public function index()
    {
        $settings = AppSetting::getMany($this->defaultSettings());
        $kepalaUptd  = KepalaUptd::first(); 

        return view('seting', compact('settings', 'kepalaUptd'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'kop_instansi_induk' => ['required', 'string', 'max:255'],
            'kop_dinas_nama' => ['required', 'string', 'max:500'],
            'kop_sub_instansi' => ['required', 'string', 'max:255'],
            'kop_alamat' => ['required', 'string', 'max:500'],
            'kop_email' => ['nullable', 'email', 'max:255'],
            'kop_website' => ['nullable', 'string', 'max:255'],

            'ttd_kota' => ['required', 'string', 'max:100'],
            'ttd_jabatan' => ['required', 'string', 'max:255'],
            'ttd_nama' => ['required', 'string', 'max:255'],
            'ttd_nip' => ['nullable', 'string', 'max:100'],

            'kop_logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'ttd_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        unset($validated['kop_logo'], $validated['ttd_image']);

        foreach ($validated as $key => $value) {
            AppSetting::setValue($key, $value);
        }

        if ($request->hasFile('kop_logo')) {
            $oldLogo = AppSetting::getValue('kop_logo');

            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }

            $path = $request->file('kop_logo')->store('settings', 'public');
            AppSetting::setValue('kop_logo', $path);
        }

        if ($request->hasFile('ttd_image')) {
            $oldTtd = AppSetting::getValue('ttd_image');

            if ($oldTtd && Storage::disk('public')->exists($oldTtd)) {
                Storage::disk('public')->delete($oldTtd);
            }

            $path = $request->file('ttd_image')->store('settings', 'public');
            AppSetting::setValue('ttd_image', $path);
        }

        return redirect()
            ->route('seting.index')
            ->with('success', 'Pengaturan kop surat berhasil diperbarui.');
    }

    private function defaultSettings(): array
    {
        return [
            'kop_instansi_induk' => 'Pemerintah Kabupaten Karangasem',
            'kop_dinas_nama' => 'Dinas Sosial, Pemberdayaan Perempuan dan Perlindungan Anak, Pengendalian Penduduk dan Keluarga Berencana',
            'kop_sub_instansi' => 'UPTD Perlindungan Perempuan dan Anak',
            'kop_alamat' => 'Jalan Ngurah Rai No. 70 Telp. (0363) 21154 Amlapura',
            'kop_email' => 'disosppappkbkab.karangasem@gmail.com',
            'kop_website' => 'http://disosp3appkb.karangasemkab.go.id',

            'ttd_kota' => 'Amlapura',
            'ttd_jabatan' => 'Kepala UPTD Perlindungan Perempuan dan Anak Kabupaten Karangasem',
            'ttd_nama' => 'Ni Nyoman Budiartini S.Sos.MAP',
            'ttd_nip' => '19761006 200604 2 007',

            'kop_logo' => null,
            'ttd_image' => null,
        ];
    }
    
    public function knowledge()
    {
        $jenisKasusList = JenisKasus::all();
        $undangUndangList = UndangUndang::all();
        $faqList = Faq::all();
        $sopList = Sop::all();
        $panduanList = PanduanKeamanan::all(); 

        return view('seting_knowledge', compact(
            'jenisKasusList', 'undangUndangList', 'faqList', 'sopList', 'panduanList'
        ));
    }

    // ── Jenis Kasus ──
    public function storeJenis(Request $request)
    {
        $request->validate([
            'jenis_kasus'=> 'required|string|max:255',
            'pengertian' => 'required|string',
            'aksi'       => 'nullable|string|max:255',
        ]);
        JenisKasus::create($request->only('jenis_kasus', 'pengertian', 'aksi'));
        return redirect()->route('seting.knowledge')->with('success', 'Jenis kasus berhasil ditambahkan.');
    }

    public function updateJenis(Request $request, $id)
    {
        $request->validate([
            'jenis_kasus'=> 'required|string|max:255',
            'pengertian' => 'required|string',
            'aksi'       => 'nullable|string|max:255',
        ]);
        JenisKasus::findOrFail($id)->update($request->only('jenis_kasus', 'pengertian', 'aksi'));
        return redirect()->route('seting.knowledge')->with('success', 'Jenis kasus berhasil diperbarui.');
    }

    public function destroyJenis($id)
    {
        JenisKasus::findOrFail($id)->delete();
        return redirect()->route('seting.knowledge')->with('success', 'Jenis kasus berhasil dihapus.');
    }

    // ── Undang-Undang ──
    public function storeUU(Request $request)
    {
        $request->validate(['nama_uu' => 'required|string', 'penjelasan_uu' => 'required|string']);
        UndangUndang::create($request->only('nama_uu', 'penjelasan_uu'));
        return redirect()->route('seting.knowledge')->with('success', 'Undang-undang berhasil ditambahkan.');
    }

    public function updateUU(Request $request, $id)
    {
        $request->validate(['nama_uu' => 'required|string', 'penjelasan_uu' => 'required|string']);
        UndangUndang::findOrFail($id)->update($request->only('nama_uu', 'penjelasan_uu'));
        return redirect()->route('seting.knowledge')->with('success', 'Undang-undang berhasil diperbarui.');
    }

    public function destroyUU($id)
    {
        UndangUndang::findOrFail($id)->delete();
        return redirect()->route('seting.knowledge')->with('success', 'Undang-undang berhasil dihapus.');
    }

    // ── FAQ ──
    public function storeFaq(Request $request)
    {
        $request->validate(['pertanyaan' => 'required|string', 'jawaban' => 'required|string']);
        Faq::create($request->only('pertanyaan', 'jawaban'));
        return redirect()->route('seting.knowledge')->with('success', 'FAQ berhasil ditambahkan.');
    }

    public function updateFaq(Request $request, $id)
    {
        $request->validate(['pertanyaan' => 'required|string', 'jawaban' => 'required|string']);
        Faq::findOrFail($id)->update($request->only('pertanyaan', 'jawaban'));
        return redirect()->route('seting.knowledge')->with('success', 'FAQ berhasil diperbarui.');
    }

    public function destroyFaq($id)
    {
        Faq::findOrFail($id)->delete();
        return redirect()->route('seting.knowledge')->with('success', 'FAQ berhasil dihapus.');
    }

    // ── SOP ──
    public function storeSop(Request $request)
    {
        $request->validate(['sop' => 'required|string']);
        Sop::create($request->only('sop'));
        return redirect()->route('seting.knowledge')->with('success', 'SOP berhasil ditambahkan.');
    }

    public function updateSop(Request $request, $id)
    {
        $request->validate(['sop' => 'required|string']);
        Sop::findOrFail($id)->update($request->only('sop'));
        return redirect()->route('seting.knowledge')->with('success', 'SOP berhasil diperbarui.');
    }

    public function destroySop($id)
    {
        Sop::findOrFail($id)->delete();
        return redirect()->route('seting.knowledge')->with('success', 'SOP berhasil dihapus.');
    }

    // ── Panduan Keamanan & Edukasi Mandiri ──
    public function storePanduan(Request $request)
    {
        $request->validate([
            'kategori'          => 'required|array',
            'kategori.*'        => 'required|string|max:255',
            'tindakan_keamanan' => 'required|string',
            'preservasi_bukti'  => 'required|string',
            'edukasi'           => 'required|string',
        ]);

        PanduanKeamanan::create([
            'kategori'          => $request->kategori,
            'tindakan_keamanan' => $request->tindakan_keamanan,
            'preservasi_bukti'  => $request->preservasi_bukti,
            'edukasi'           => $request->edukasi,
        ]);

        return redirect()->route('seting.knowledge')->with('success', 'Panduan keamanan berhasil ditambahkan.');
    }

    public function updatePanduan(Request $request, $id)
    {
        $request->validate([
            'kategori'          => 'required|array',
            'kategori.*'        => 'required|string|max:255',
            'tindakan_keamanan' => 'required|string',
            'preservasi_bukti'  => 'required|string',
            'edukasi'           => 'required|string',
        ]);

        $panduan = PanduanKeamanan::findOrFail($id);
        $panduan->update([
            'kategori'          => $request->kategori,
            'tindakan_keamanan' => $request->tindakan_keamanan,
            'preservasi_bukti'  => $request->preservasi_bukti,
            'edukasi'           => $request->edukasi,
        ]);

        return redirect()->route('seting.knowledge')->with('success', 'Panduan keamanan berhasil diperbarui.');
    }

    public function destroyPanduan($id)
    {
        PanduanKeamanan::findOrFail($id)->delete();
        return redirect()->route('seting.knowledge')->with('success', 'Panduan keamanan berhasil dihapus.');
    }

    public function updateKepala(Request $request)
    {
        $request->validate([
            'nama_kepala' => 'required|string|max:255',
            'nip'         => 'required|string|max:50',
            'no_telp'     => 'nullable|string|max:20',
        ], [
            'nama_kepala.required' => 'Nama kepala wajib diisi.',
            'nip.required'         => 'NIP wajib diisi.',
        ]);

        $kepala = KepalaUptd::first();

        if ($kepala) {
            $kepala->update($request->only('nama_kepala', 'nip', 'no_telp'));
        } else {
            KepalaUptd::create($request->only('nama_kepala', 'nip', 'no_telp'));
        }

        return redirect()->route('seting.index')
            ->with('success', 'Data kepala UPTD berhasil diperbarui.');
    }
}