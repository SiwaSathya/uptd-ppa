<?php

namespace App\Http\Controllers;

use App\Models\LaporanKasusPpa;
use Carbon\Carbon;
use Illuminate\Http\Request;

class Publik extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->has('tahun') ? $request->get('tahun') : date('Y');
        $tampilSemua = !$request->has('tahun');

        /*
        |--------------------------------------------------------------------------
        | MASTER DATA
        |--------------------------------------------------------------------------
        | Ubah angka populasi di sini jika nanti kamu punya data resmi.
        | Populasi dipakai untuk menghitung rate perempuan dan anak.
        */

        $kecamatanMaster = [
            'Abang',
            'Bebandem',
            'Karangasem',
            'Kubu',
            'Manggis',
            'Rendang',
            'Selat',
            'Sidemen',
        ];

        $populasiPerempuan = [
            'Abang'      => 1,
            'Bebandem'   => 1,
            'Karangasem' => 1,
            'Kubu'       => 1,
            'Manggis'    => 1,
            'Rendang'    => 1,
            'Selat'      => 1,
            'Sidemen'    => 1,
        ];

        $populasiAnak = [
            'Abang'      => 1,
            'Bebandem'   => 1,
            'Karangasem' => 1,
            'Kubu'       => 1,
            'Manggis'    => 1,
            'Rendang'    => 1,
            'Selat'      => 1,
            'Sidemen'    => 1,
        ];

        /*
        |--------------------------------------------------------------------------
        | BASE QUERY BERDASARKAN TAHUN
        |--------------------------------------------------------------------------
        */

        $queryTahun = LaporanKasusPpa::query();
        // Hanya filter tahun jika bukan mode "Semua"
        if (!$tampilSemua) {
            $queryTahun->whereYear('created_at', $tahun);
        }

        /*
        |--------------------------------------------------------------------------
        | STAT CARD
        |--------------------------------------------------------------------------
        */

        // Kasus Selesai = status true, difilter tahun yang aktif
        $kasusSelesai = (clone $queryTahun)
            ->where('status', true)
            ->count();

        // Kasus Masuk = SEMUA data di database (total keseluruhan, tanpa filter tahun)
        $kasusMasuk = LaporanKasusPpa::query()->count();

        // Kasus Dalam Proses = status false, difilter tahun yang aktif
        $kasusProses = (clone $queryTahun)
            ->where('status', false)
            ->count();

        // Kasus Baru = masuk hari ini saja (tanpa filter tahun)
        $kasusBaru = LaporanKasusPpa::query()
            ->whereDate('created_at', Carbon::today())
            ->count();

        /*
        |--------------------------------------------------------------------------
        | CHART WILAYAH
        |--------------------------------------------------------------------------
        */

        $wilayah = (clone $queryTahun)
            ->selectRaw('kecamatan, COUNT(*) as total')
            ->whereNotNull('kecamatan')
            ->groupBy('kecamatan')
            ->orderBy('kecamatan')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | CHART BENTUK KEKERASAN PER KECAMATAN
        |--------------------------------------------------------------------------
        */

        $jenisKasus = (clone $queryTahun)
            ->selectRaw('jenis_kasus, kecamatan, COUNT(*) as total')
            ->whereNotNull('jenis_kasus')
            ->whereNotNull('kecamatan')
            ->groupBy('jenis_kasus', 'kecamatan')
            ->orderBy('kecamatan')
            ->orderBy('jenis_kasus')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | CHART KORBAN BERDASARKAN GENDER
        |--------------------------------------------------------------------------
        */

        $korban = (clone $queryTahun)
            ->selectRaw('gender_korban, COUNT(*) as total')
            ->whereNotNull('gender_korban')
            ->groupBy('gender_korban')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | CHART USIA KORBAN PER JENIS KASUS
        | Masih disiapkan jika nanti kamu ingin pakai chart usia.
        |--------------------------------------------------------------------------
        */

        $usiaKasus = (clone $queryTahun)
            ->selectRaw('jenis_kasus, AVG(usia_korban) as avg_usia, COUNT(*) as total')
            ->whereNotNull('jenis_kasus')
            ->whereNotNull('usia_korban')
            ->groupBy('jenis_kasus')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | CHART PELAKU
        |--------------------------------------------------------------------------
        */

        $pelakuGender = (clone $queryTahun)
            ->selectRaw('gender_pelaku, COUNT(*) as total')
            ->whereNotNull('gender_pelaku')
            ->groupBy('gender_pelaku')
            ->get();

        $hubunganPelaku = (clone $queryTahun)
            ->selectRaw('hubungan_pelaku, COUNT(*) as total')
            ->whereNotNull('hubungan_pelaku')
            ->groupBy('hubungan_pelaku')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | CHART TEMPAT KEJADIAN
        |--------------------------------------------------------------------------
        */

        $tempatKejadian = (clone $queryTahun)
            ->selectRaw('lokasi_spesifik, COUNT(*) as total')
            ->whereNotNull('lokasi_spesifik')
            ->groupBy('lokasi_spesifik')
            ->get();

        $tempatKorban = (clone $queryTahun)
            ->selectRaw('lokasi_spesifik, COUNT(*) as total')
            ->whereNotNull('lokasi_spesifik')
            ->whereNotNull('nama_korban')
            ->groupBy('lokasi_spesifik')
            ->get();

         /*
        |--------------------------------------------------------------------------
        | RENTANG UMUR KORBAN PEREMPUAN
        |--------------------------------------------------------------------------
        */
        $rentangUmurPerempuan = (clone $queryTahun)
            ->selectRaw("
                CASE
                    WHEN usia_korban BETWEEN 0  AND 4  THEN '0-4 thn'
                    WHEN usia_korban BETWEEN 5  AND 9  THEN '5-9 thn'
                    WHEN usia_korban BETWEEN 10 AND 14 THEN '10-14 thn'
                    WHEN usia_korban BETWEEN 15 AND 17 THEN '15-17 thn'
                    WHEN usia_korban BETWEEN 18 AND 24 THEN '18-24 thn'
                    WHEN usia_korban BETWEEN 25 AND 34 THEN '25-34 thn'
                    WHEN usia_korban BETWEEN 35 AND 44 THEN '35-44 thn'
                    WHEN usia_korban BETWEEN 45 AND 59 THEN '45-59 thn'
                    WHEN usia_korban >= 60             THEN '60+ thn'
                    ELSE 'Tidak diketahui'
                END as rentang,
                COUNT(*) as total
            ")
            ->whereNotNull('usia_korban')
            ->whereRaw("LOWER(gender_korban) = ?", ['perempuan'])
            ->groupByRaw("
                CASE
                    WHEN usia_korban BETWEEN 0  AND 4  THEN '0-4 thn'
                    WHEN usia_korban BETWEEN 5  AND 9  THEN '5-9 thn'
                    WHEN usia_korban BETWEEN 10 AND 14 THEN '10-14 thn'
                    WHEN usia_korban BETWEEN 15 AND 17 THEN '15-17 thn'
                    WHEN usia_korban BETWEEN 18 AND 24 THEN '18-24 thn'
                    WHEN usia_korban BETWEEN 25 AND 34 THEN '25-34 thn'
                    WHEN usia_korban BETWEEN 35 AND 44 THEN '35-44 thn'
                    WHEN usia_korban BETWEEN 45 AND 59 THEN '45-59 thn'
                    WHEN usia_korban >= 60             THEN '60+ thn'
                    ELSE 'Tidak diketahui'
                END
            ")
            ->get();

        /*
        |--------------------------------------------------------------------------
        | RENTANG UMUR KORBAN ANAK (usia <= 17)
        |--------------------------------------------------------------------------
        */
        $rentangUmurAnak = (clone $queryTahun)
            ->selectRaw("
                CASE
                    WHEN usia_korban BETWEEN 0  AND 4  THEN '0-4 thn'
                    WHEN usia_korban BETWEEN 5  AND 9  THEN '5-9 thn'
                    WHEN usia_korban BETWEEN 10 AND 14 THEN '10-14 thn'
                    WHEN usia_korban BETWEEN 15 AND 17 THEN '15-17 thn'
                    ELSE 'Tidak diketahui'
                END as rentang,
                COUNT(*) as total
            ")
            ->whereNotNull('usia_korban')
            ->where('usia_korban', '<=', 17)
            ->groupByRaw("
                CASE
                    WHEN usia_korban BETWEEN 0  AND 4  THEN '0-4 thn'
                    WHEN usia_korban BETWEEN 5  AND 9  THEN '5-9 thn'
                    WHEN usia_korban BETWEEN 10 AND 14 THEN '10-14 thn'
                    WHEN usia_korban BETWEEN 15 AND 17 THEN '15-17 thn'
                    ELSE 'Tidak diketahui'
                END
            ")
            ->get();

        /*
        |--------------------------------------------------------------------------
        | KORBAN MENURUT BANYAKNYA KEKERASAN YANG DIALAMI
        |--------------------------------------------------------------------------
        | Jika jenis_kasus kamu hanya 1 nilai per laporan, maka semua akan masuk
        | ke kategori "1 Jenis".
        |
        | Jika jenis_kasus berisi beberapa nilai, contoh:
        | "Fisik, Psikis, Seksual"
        | maka sistem akan menghitungnya sebagai 3 jenis.
        */

        $banyakKekerasanCounter = [
            '1 Jenis'  => 0,
            '2 Jenis'  => 0,
            '3 Jenis'  => 0,
            '>3 Jenis' => 0,
        ];

        $dataJenisKasusMentah = (clone $queryTahun)
            ->select('jenis_kasus')
            ->whereNotNull('jenis_kasus')
            ->get();

        foreach ($dataJenisKasusMentah as $item) {
            $jenisArray = collect(explode(',', $item->jenis_kasus))
                ->map(fn ($value) => trim($value))
                ->filter()
                ->values();

            $jumlahJenis = $jenisArray->count();

            if ($jumlahJenis <= 1) {
                $banyakKekerasanCounter['1 Jenis']++;
            } elseif ($jumlahJenis === 2) {
                $banyakKekerasanCounter['2 Jenis']++;
            } elseif ($jumlahJenis === 3) {
                $banyakKekerasanCounter['3 Jenis']++;
            } else {
                $banyakKekerasanCounter['>3 Jenis']++;
            }
        }

        $banyakKekerasan = collect($banyakKekerasanCounter)
            ->map(function ($total, $kategori) {
                return [
                    'kategori' => $kategori,
                    'total'    => $total,
                ];
            })
            ->values();

        /*
        |--------------------------------------------------------------------------
        | DAFTAR TAHUN
        |--------------------------------------------------------------------------
        */

        $tahunList = LaporanKasusPpa::query()
            ->selectRaw('EXTRACT(YEAR FROM created_at)::integer as tahun')
            ->whereNotNull('created_at')
            ->groupBy('tahun')
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        return view('publik', compact(
            'kasusSelesai', 'kasusMasuk', 'kasusProses', 'kasusBaru',
            'wilayah', 'jenisKasus', 'korban',
            'usiaKasus', 'pelakuGender', 'tempatKejadian',
            'tempatKorban', 'hubunganPelaku',
            'rentangUmurPerempuan', 'rentangUmurAnak', // ← ganti ratePerempuan & rateAnak
            'banyakKekerasan', 'tahunList', 'tahun', 'tampilSemua'
        ));
    }
}