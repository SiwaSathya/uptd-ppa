@extends('template')

@section('css')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan - UPTD PPA Karangasem</title>

    <link rel="shortcut icon" href="/assets/compiled/svg/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="/assets/compiled/css/app.css">
    <link rel="stylesheet" href="/assets/compiled/css/app-dark.css">
    <link rel="stylesheet" href="/assets/compiled/css/iconly.css">

   <style>
    /* ===== SCREEN STYLES ===== */
    .laporan-wrapper {
        background: #fff;
        color: #000;
        max-width: 900px;
        margin: 0 auto;
        padding: 30px 40px;
        border: 1px solid #dee2e6;
        border-radius: 8px;
    }

    .kop-surat {
        display: flex;
        align-items: center;
        gap: 20px;
        border-bottom: 3px solid #000;
        padding-bottom: 12px;
        margin-bottom: 6px;
    }
    .kop-surat img { width: 90px; height: 90px; object-fit: contain; }
    .kop-text { flex: 1; text-align: center; line-height: 1.4; }
    .kop-text .instansi-induk  { font-size: 0.8rem;  font-weight: 600; text-transform: uppercase; }
    .kop-text .instansi-nama   { font-size: 1rem;    font-weight: 800; text-transform: uppercase; }
    .kop-text .instansi-sub    { font-size: 0.85rem; font-weight: 700; text-transform: uppercase; }
    .kop-text .instansi-alamat { font-size: 0.72rem; margin-top: 4px; }
    .kop-text .instansi-alamat a { color: #000; }

    .kop-garis { border: none; border-top: 1.5px solid #000; margin: 4px 0 16px; }

    .judul-laporan {
        text-align: center;
        font-weight: 700;
        font-size: 0.95rem;
        text-transform: uppercase;
        margin-bottom: 16px;
        text-decoration: underline;
    }

    /* Filter bar */
    .filter-bar {
        display: flex;
        gap: 12px;
        align-items: center;
        margin-bottom: 16px;
        flex-wrap: wrap;
    }
    .filter-bar label {
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--bs-body-color);
    }
    .filter-bar select,
    .filter-bar input {
        border: 1px solid var(--bs-border-color);
        border-radius: 4px;
        padding: 4px 10px;
        font-size: 0.85rem;
        background-color: var(--bs-body-bg);
        color: var(--bs-body-color);
    }

    /* Tabel - selalu hitam putih karena untuk cetak */
    .tabel-laporan {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.78rem;
    }
    .tabel-laporan th,
    .tabel-laporan td {
        border: 1px solid #000;
        text-align: center;
        padding: 4px 6px;
        vertical-align: middle;
        color: #000;
        background-color: #fff;
    }
    .tabel-laporan th { font-weight: 700; text-transform: uppercase; }
    .tabel-laporan td.text-left { text-align: left; }
    .tabel-laporan tr.jumlah-row td,
    .tabel-laporan tr.total-row td { font-weight: 700; }
    .tabel-laporan tr.total-row td { background-color: #f5f5f5 !important; }

    /* TTD */
    .ttd-section { margin-top: 30px; display: flex; justify-content: flex-end; }
    .ttd-box { text-align: center; font-size: 0.85rem; color: #000; }
    .ttd-box .ttd-nama { font-weight: 700; text-decoration: underline; margin-top: 10px; }
    .ttd-box .ttd-nip  { font-size: 0.8rem; }

    /* Tombol */
    .btn-cetak {
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 12px 60px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
    }
    .btn-cetak-print  { background-color: #1e3a5f; }
    .btn-cetak-print:hover { background-color: #162d4a; }
    .btn-cetak-pdf    { background-color: #dc2626; }
    .btn-cetak-pdf:hover { background-color: #b91c1c; }

    /* Dark mode: wrapper tetap putih karena untuk cetak */
    [data-bs-theme="dark"] .laporan-wrapper,
    .layout-dark .laporan-wrapper {
        background: #fff !important;
        color: #000 !important;
        border-color: #555;
    }

    /* ===== PRINT STYLES ===== */
    @media print {
        body * { visibility: hidden; }
        #area-cetak, #area-cetak * { visibility: visible; }
        #area-cetak {
            position: absolute;
            top: 0; left: 0;
            width: 100%;
            padding: 20px;
            border: none !important;
            border-radius: 0;
            background: #fff !important;
            color: #000 !important;
        }
        .btn-cetak-wrap,
        .filter-bar,
        .page-heading h3 { display: none !important; }
    }
</style>
@endsection

@section('main')
<div class="page-heading">
    <h3>Cetak Laporan</h3>
</div>

<div class="page-content">
    <section class="section">

        {{-- Filter --}}
        <div class="filter-bar d-print-none mb-3">
            <label>Tahun Awal:</label>
            <select id="tahun-awal">
                @for($y = 2022; $y <= date('Y'); $y++)
                    <option value="{{ $y }}" {{ $y == 2022 ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
            <label>Tahun Akhir:</label>
            <select id="tahun-akhir">
                @for($y = 2022; $y <= date('Y'); $y++)
                    <option value="{{ $y }}" {{ $y == date('Y') ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
            <button class="btn btn-primary btn-sm" onclick="generateTabel()">Tampilkan</button>
        </div>

        {{-- Area Cetak --}}
        <div class="laporan-wrapper" id="area-cetak">

           
            
           {{-- Kop Surat --}}
            @php
                $s = \App\Models\AppSetting::getMany([
                    'kop_instansi_induk' => 'Pemerintah Kabupaten Karangasem',
                    'kop_dinas_nama'     => 'Dinas Sosial, Pemberdayaan Perempuan dan Perlindungan Anak',
                    'kop_sub_instansi'   => 'UPTD Perlindungan Perempuan dan Anak',
                    'kop_alamat'         => 'Jalan Ngurah Rai No. 70 Telp. (0363) 21154 Amlapura',
                    'kop_email'          => 'disosppappkbkab.karangasem@gmail.com',
                    'kop_website'        => 'http://disosp3appkb.karangasemkab.go.id',
                    'kop_logo'           => null,
                    'ttd_kota'           => 'Amlapura',
                    'ttd_jabatan'        => 'Kepala UPTD PPA Kab Karangasem',
                    'ttd_nama'           => 'Ni Nyoman Budiartini S.Sos.MAP',
                    'ttd_nip'            => '19761006 200604 2 007',
                    'ttd_image'          => null,
                ]);
            @endphp

            <div class="kop-surat">
                <img src="{{ $s['kop_logo'] ? Storage::url($s['kop_logo']) : asset('/assets/compiled/png/logo_ppa.PNG') }}"
                    onerror="this.style.display='none'"
                    alt="Logo">
                <div class="kop-text">
                    <div class="instansi-induk">{{ $s['kop_instansi_induk'] }}</div>
                    <div class="instansi-nama">{{ $s['kop_dinas_nama'] }}</div>
                    <div class="instansi-sub">{{ $s['kop_sub_instansi'] }}</div>
                    <div class="instansi-alamat">
                        {{ $s['kop_alamat'] }}<br>
                        e-mail : <a href="mailto:{{ $s['kop_email'] }}">{{ $s['kop_email'] }}</a><br>
                        laman : <a href="{{ $s['kop_website'] }}">{{ $s['kop_website'] }}</a>
                    </div>
                </div>
            </div>
            <hr class="kop-garis">

             {{-- Judul --}}
            <div class="judul-laporan" id="judul-laporan">
                Data Korban Kasus Kekerasan Terhadap Anak Tahun <span id="judul-tahun">2022-{{ date('Y') }}</span>
            </div>

            {{-- Tabel --}}
            <div class="table-responsive">
                <table class="tabel-laporan" id="tabel-laporan">
                    <thead id="thead-laporan">
                        {{-- diisi oleh JS --}}
                    </thead>
                    <tbody id="tbody-laporan">
                        {{-- diisi oleh JS --}}
                    </tbody>
                </table>
            </div>

            {{-- Ganti juga bagian TTD --}}
            <div class="ttd-section">
                <div class="ttd-box">
                    <div>{{ $s['ttd_kota'] }}, {{ \Carbon\Carbon::now()->translatedFormat('j F Y') }}</div>
                    <div>{{ $s['ttd_jabatan'] }}</div>
                    <div style="height:90px;display:flex;align-items:center;justify-content:center;">
                        <img src="{{ $s['ttd_image'] ? Storage::url($s['ttd_image']) : '/assets/compiled/png/2.png' }}"
                            alt="TTD"
                            style="max-height:90px;max-width:180px;object-fit:contain;"
                            onerror="this.style.display='none'">
                    </div>
                    <div class="ttd-nama">{{ $s['ttd_nama'] }}</div>
                    <div class="ttd-nip">NIP. {{ $s['ttd_nip'] }}</div>
                </div>
            </div>

        </div>

        {{-- Tombol Cetak & Download PDF --}}
        <div class="btn-cetak-wrap d-print-none d-flex justify-content-center gap-3 mt-3">
            <button class="btn-cetak btn-cetak-print" onclick="window.print()">
                <i class="bi bi-printer me-2"></i> Cetak
            </button>
            <button class="btn-cetak btn-cetak-pdf" onclick="downloadPDF()">
                <i class="bi bi-file-earmark-pdf me-2"></i> Download PDF
            </button>
        </div>

    </section>
</div>

<footer>
    <div class="footer clearfix mb-0 text-muted"></div>
</footer>
@endsection

@section('js')

<script src="/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>


<script>
    const rawData = @json($data);

    const jenisKasus = [
        'KDRT Fisik','KDRT Psikis','Persetubuhan','Pelecehan','Pemerkosaan',
        'Penelantaran','Penganiayaan','Pencurian','Bullying','TPPO (Trafficking)',
        'Pedofilia','Ekspolitasi seksual','Ekspolitasi ekonomi','Korban kejahatan ITE','Trauma Lakalantas',
        'Lain-lain','Tidak diketahui'
    ];

    // Satu fungsi hitung yang benar — case-insensitive, exact match
    function hitung(tahun, kasusNama, isAnak, gender) {
        return rawData.filter(d => {
            const tgl = new Date(d.tanggal_kejadian);
            const thn = tgl.getFullYear();
            const usia = parseInt(d.usia_korban) || 0;
            const cekUsia = isAnak ? usia < 18 : usia >= 18;

            const jenis = (d.jenis_kasus || '').toLowerCase().trim();
            const nama  = kasusNama.toLowerCase().trim();

            return thn === tahun
                && cekUsia
                && (d.gender_korban || '').toLowerCase() === gender.toLowerCase()
                && jenis === nama;   // <-- exact match, bukan includes()
        }).length;
    }

    function generateTabel() {
        const thnAwal  = parseInt(document.getElementById('tahun-awal').value);
        const thnAkhir = parseInt(document.getElementById('tahun-akhir').value);

        if (thnAwal > thnAkhir) {
            alert('Tahun awal tidak boleh lebih besar dari tahun akhir.');
            return;
        }

        document.getElementById('judul-tahun').textContent = thnAwal + '-' + thnAkhir;

        const tahunList = [];
        for (let y = thnAwal; y <= thnAkhir; y++) tahunList.push(y);

        // Buat header
        let thead = `
            <tr>
                <th rowspan="4">NO</th>
                <th rowspan="4">BENTUK<br>KEKERASAN</th>
                ${tahunList.map(y => `<th colspan="4">${y}</th>`).join('')}
            </tr>
            <tr>
                ${tahunList.map(() => `<th colspan="4">JANUARI-DESEMBER</th>`).join('')}
            </tr>
            <tr>
                ${tahunList.map(() => `<th colspan="2">ANAK</th><th colspan="2">DEWASA</th>`).join('')}
            </tr>
            <tr>
                ${tahunList.map(() => `<th>P</th><th>L</th><th>P</th><th>L</th>`).join('')}
            </tr>
        `;
        document.getElementById('thead-laporan').innerHTML = thead;

        const grandTotals = tahunList.map(() => [0, 0, 0, 0]);

        let tbody = '';
        jenisKasus.forEach((kasus, idx) => {
            tbody += `<tr>
                <td>${idx + 1}</td>
                <td class="text-left">${kasus}</td>`;

            tahunList.forEach((y, yi) => {
                const ap = hitung(y, kasus, true,  'Perempuan');
                const al = hitung(y, kasus, true,  'Laki-laki');
                const dp = hitung(y, kasus, false, 'Perempuan');
                const dl = hitung(y, kasus, false, 'Laki-laki');

                grandTotals[yi][0] += ap;
                grandTotals[yi][1] += al;
                grandTotals[yi][2] += dp;
                grandTotals[yi][3] += dl;

                tbody += `<td>${ap}</td><td>${al}</td><td>${dp}</td><td>${dl}</td>`;
            });

            tbody += `</tr>`;
        });

        // Baris JUMLAH
        tbody += `<tr class="jumlah-row"><td colspan="2">JUMLAH</td>`;
        const totalPerTahun = tahunList.map((y, yi) => {
            const sum = grandTotals[yi].reduce((a, b) => a + b, 0);
            tbody += `<td>${grandTotals[yi][0]}</td><td>${grandTotals[yi][1]}</td><td>${grandTotals[yi][2]}</td><td>${grandTotals[yi][3]}</td>`;
            return sum;
        });
        tbody += `</tr>`;

        // Baris TOTAL
        tbody += `<tr class="total-row"><td colspan="2">TOTAL</td>`;
        totalPerTahun.forEach(t => {
            tbody += `<td colspan="4">${t}</td>`;
        });
        tbody += `</tr>`;

        document.getElementById('tbody-laporan').innerHTML = tbody;
    }

    generateTabel();

    // Debug helper — buka console browser untuk cek nilai unik jenis_kasus di DB
    console.log('Jenis kasus unik di DB:', [...new Set(rawData.map(d => d.jenis_kasus))]);
    console.log('Gender unik di DB:', [...new Set(rawData.map(d => d.gender_korban))]);
</script>
{{-- Library jsPDF + html2canvas --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
    async function downloadPDF() {
        const { jsPDF } = window.jspdf;

        const element = document.getElementById('area-cetak');

        // Simpan style asli
        const originalBg     = element.style.background;
        const originalColor  = element.style.color;
        const originalBorder = element.style.border;

        // Paksa warna hitam putih untuk PDF
        element.style.background = '#ffffff';
        element.style.color      = '#000000';

        // Tampilkan loading
        const btnPdf = document.querySelector('[onclick="downloadPDF()"]');
        const originalText = btnPdf.innerHTML;
        btnPdf.innerHTML = '<i class="bi bi-hourglass-split me-2"></i> Memproses...';
        btnPdf.disabled = true;

        try {
            const canvas = await html2canvas(element, {
                scale: 2,
                useCORS: true,
                allowTaint: true,
                backgroundColor: '#ffffff',
                logging: false,
            });

            const imgData    = canvas.toDataURL('image/png');
            const pdf        = new jsPDF('p', 'mm', 'a4');
            const pdfWidth   = pdf.internal.pageSize.getWidth();
            const pdfHeight  = pdf.internal.pageSize.getHeight();
            const imgWidth   = pdfWidth;
            const imgHeight  = (canvas.height * pdfWidth) / canvas.width;

            let heightLeft   = imgHeight;
            let position     = 0;

            // Halaman pertama
            pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
            heightLeft -= pdfHeight;

            // Halaman berikutnya jika konten panjang
            while (heightLeft > 0) {
                position   = heightLeft - imgHeight;
                pdf.addPage();
                pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                heightLeft -= pdfHeight;
            }

            // Nama file berdasarkan tahun
            const thnAwal  = document.getElementById('tahun-awal').value;
            const thnAkhir = document.getElementById('tahun-akhir').value;
            pdf.save(`Laporan_UPTD_PPA_${thnAwal}-${thnAkhir}.pdf`);

        } catch (err) {
            alert('Gagal membuat PDF: ' + err.message);
        } finally {
            // Kembalikan style asli
            element.style.background = originalBg;
            element.style.color      = originalColor;
            element.style.border     = originalBorder;

            btnPdf.innerHTML = originalText;
            btnPdf.disabled  = false;
        }
    }
</script>
@endsection