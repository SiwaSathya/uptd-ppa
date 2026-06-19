@extends('bar')

@section('css')
<style>
    .dashboard-admin {
        --dash-primary: #435ebe;
        --dash-success: #198754;
        --dash-info: #0dcaf0;
        --dash-warning: #ffc107;
        --dash-danger: #dc3545;
        --dash-border: rgba(120, 130, 160, .18);
        --dash-soft-primary: rgba(67, 94, 190, .10);
        --dash-soft-success: rgba(25, 135, 84, .10);
        --dash-soft-info: rgba(13, 202, 240, .12);
        --dash-soft-warning: rgba(255, 193, 7, .14);
        --dash-soft-danger: rgba(220, 53, 69, .10);
    }

    .dashboard-admin .page-title {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
        flex-wrap: wrap;
        margin-bottom: 1.5rem;
    }

    .dashboard-admin .page-title h3 {
        font-weight: 800;
        margin-bottom: .25rem;
    }

    .dashboard-admin .page-title p {
        margin-bottom: 0;
    }

    .dashboard-admin .clean-card {
        border: 1px solid var(--dash-border);
        border-radius: 18px;
        box-shadow: 0 8px 24px rgba(20, 24, 40, .05);
        overflow: hidden;
    }

    .dashboard-admin .clean-card .card-header {
        background: transparent;
        border-bottom: 1px solid var(--dash-border);
        padding: 1rem 1.25rem;
    }

    .dashboard-admin .clean-card .card-header h4 {
        font-weight: 800;
        margin-bottom: .15rem;
        font-size: 1.08rem;
    }

    .dashboard-admin .clean-card .card-header small {
        color: var(--bs-secondary-color);
    }

    .dashboard-admin .clean-card .card-body {
        padding: 1.25rem;
    }

    .dashboard-admin .stat-card {
        border-radius: 18px;
        border: 1px solid var(--dash-border);
        padding: 1.15rem;
        height: 100%;
        display: flex;
        align-items: center;
        gap: 1rem;
        box-shadow: 0 8px 24px rgba(20, 24, 40, .05);
    }

    .dashboard-admin .stat-icon {
        background: transparent;
        font-size: 1.45rem;
        flex: 0 0 auto;
    }

    .dashboard-admin .stat-label {
        color: var(--bs-secondary-color);
        font-weight: 700;
        font-size: .86rem;
        margin-bottom: .25rem;
    }

    .dashboard-admin .stat-value {
        font-size: 1.45rem;
        line-height: 1;
        font-weight: 900;
    }

    .dashboard-admin .stat-success { background: var(--dash-soft-success); }
    .dashboard-admin .stat-info    { background: var(--dash-soft-info); }
    .dashboard-admin .stat-warning { background: var(--dash-soft-warning); }
    .dashboard-admin .stat-danger  { background: var(--dash-soft-danger); }

    .dashboard-admin .stat-success .stat-icon { background: rgba(25,135,84,.14);  color: var(--dash-success); }
    .dashboard-admin .stat-info    .stat-icon { background: rgba(13,202,240,.16); color: #0aa2c0; }
    .dashboard-admin .stat-warning .stat-icon { background: rgba(255,193,7,.18);  color: #b58100; }
    .dashboard-admin .stat-danger  .stat-icon { background: rgba(220,53,69,.13);  color: var(--dash-danger); }

    .dashboard-admin .filter-card {
        border: 1px solid var(--dash-border);
        border-radius: 18px;
    }

    .dashboard-admin .section-heading {
        display: flex;
        align-items: center;
        gap: .65rem;
        margin: 2rem 0 1rem;
    }

    .dashboard-admin .section-icon {
        width: 38px;
        height: 38px;
        border-radius: 12px;
        background: var(--dash-soft-primary);
        color: var(--dash-primary);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .dashboard-admin .section-heading h5 {
        font-weight: 900;
        margin-bottom: 0;
    }

    .dashboard-admin .section-heading small {
        color: var(--bs-secondary-color);
    }

    .dashboard-admin .chart-box {
        min-height: 365px;
        width: 100%;
    }

    .dashboard-admin .chart-box.chart-large {
        min-height: 430px;
    }

    [data-bs-theme="dark"] .dashboard-admin .clean-card,
    [data-bs-theme="dark"] .dashboard-admin .stat-card,
    [data-bs-theme="dark"] .dashboard-admin .filter-card,
    .theme-dark .dashboard-admin .clean-card,
    .theme-dark .dashboard-admin .stat-card,
    .theme-dark .dashboard-admin .filter-card {
        box-shadow: none;
    }

    @media (max-width: 768px) {
        .dashboard-admin .chart-box      { min-height: 330px; }
        .dashboard-admin .clean-card .card-body { padding: 1rem; }
        .dashboard-admin .stat-card      { padding: 1rem; }
    }
</style>
@endsection

@section('main')
<div class="dashboard-admin">
    <div class="page-title">
        <div>
            <h3>Dashboard Publik</h3>
            <p class="text-muted">Monitoring pelaporan perempuan dan anak Kabupaten Karangasem</p>
        </div>
        <div class="text-muted small">
            <i class="bi bi-calendar3 me-1"></i>
            Tahun aktif: <strong>{{ $tahun ?? date('Y') }}</strong>
        </div>
    </div>

    {{-- STAT CARDS --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-xl-3">
            <div class="stat-card stat-success">
                <div class="stat-icon"><i class="bi bi-check2-circle"></i></div>
                <div>
                    <div class="stat-label">Kasus Selesai</div>
                    <div class="stat-value">{{ $kasusSelesai ?? 0 }}</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="stat-card stat-info">
                <div class="stat-icon"><i class="bi bi-envelope-paper"></i></div>
                <div>
                    <div class="stat-label">Kasus Masuk</div>
                    <div class="stat-value">{{ $kasusMasuk ?? 0 }}</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="stat-card stat-warning">
                <div class="stat-icon"><i class="bi bi-hourglass-split"></i></div>
                <div>
                    <div class="stat-label">Dalam Proses</div>
                    <div class="stat-value">{{ $kasusProses ?? 0 }}</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="stat-card stat-danger">
                <div class="stat-icon"><i class="bi bi-bell"></i></div>
                <div>
                    <div class="stat-label">Kasus Baru</div>
                    <div class="stat-value">{{ $kasusBaru ?? 0 }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- FILTER --}}
    <div class="card filter-card mb-4">
        <div class="card-body py-3">
            <form method="GET" action="{{ request()->url() }}" class="row g-3 align-items-center">
                <div class="col-12 col-lg-auto">
                    <label class="fw-bold mb-0">
                        <i class="bi bi-funnel-fill me-1"></i> Filter Tahun
                    </label>
                </div>
                <div class="col-12 col-lg">
                    <div class="d-flex gap-2 flex-wrap">
                        @foreach(($tahunList ?? []) as $thn)
                            <a href="{{ request()->fullUrlWithQuery(['tahun' => $thn]) }}"
                               class="btn btn-sm rounded-pill {{ request()->has('tahun') && request('tahun') == $thn ? 'btn-primary fw-bold' : 'btn-outline-primary' }}">
                                {{ $thn }}
                            </a>
                        @endforeach
                        <a href="{{ request()->url() }}"
                           class="btn btn-sm rounded-pill {{ !request()->has('tahun') ? 'btn-secondary fw-bold' : 'btn-outline-secondary' }}">
                            Semua
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- STATISTIK WILAYAH --}}
    <div class="section-heading">
        <div class="section-icon"><i class="bi bi-bar-chart-line"></i></div>
        <div><h5>Statistik Wilayah dan Kekerasan</h5></div>
    </div>

    <div class="row g-3">
        <div class="col-12">
            <div class="card clean-card">
                <div class="card-header">
                    <h4>Jumlah Kasus per Kecamatan</h4>
                    <small>8 kecamatan di Kabupaten Karangasem</small>
                </div>
                <div class="card-body">
                    <div id="chart-wilayah" class="chart-box"></div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card clean-card">
                <div class="card-header">
                    <h4>Bentuk Kekerasan yang Dialami Korban</h4>
                    <small>15 kategori bentuk kekerasan per kecamatan</small>
                </div>
                <div class="card-body">
                    <div id="chart-bentuk-kekerasan" class="chart-box chart-large"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- DATA KORBAN --}}
    <div class="section-heading">
        <div class="section-icon"><i class="bi bi-person-heart"></i></div>
        <div>
            <h5>Data Korban</h5>
            <small>Distribusi korban dan angka rate</small>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-12 col-xl-4">
            <div class="card clean-card h-100">
                <div class="card-header">
                    <h4>Korban Berdasarkan Jenis Kelamin</h4>
                    <small>Perempuan dan laki-laki</small>
                </div>
                <div class="card-body">
                    <div id="chart-korban-gender" class="chart-box"></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-8">
            <div class="card clean-card h-100">
                <div class="card-header">
                    <h4>Rentang Umur Korban Perempuan</h4>
                    <small>Distribusi usia korban berjenis kelamin perempuan</small>
                </div>
                <div class="card-body">
                    <div id="chart-rentang-perempuan" class="chart-box"></div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card clean-card h-100">
                <div class="card-header">
                    <h4>Rentang Umur Korban Anak</h4>
                    <small>Distribusi usia korban anak (usia ≤ 17 tahun)</small>
                </div>
                <div class="card-body">
                    <div id="chart-rentang-anak" class="chart-box"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- TEMPAT DAN KATEGORI --}}
    <div class="section-heading">
        <div class="section-icon"><i class="bi bi-geo-alt"></i></div>
        <div><h5>Tempat Kejadian dan Kategori Kasus</h5></div>
    </div>

    <div class="row g-3">
        <div class="col-12">
            <div class="card clean-card h-100">
                <div class="card-header">
                    <h4>Jumlah Kasus Berdasarkan Tempat Kejadian</h4>
                    <small>Rumah tangga, sekolah, tempat kerja, dan lainnya</small>
                </div>
                <div class="card-body">
                    <div id="chart-tempat-kasus" class="chart-box"></div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card clean-card h-100">
                <div class="card-header">
                    <h4>Pelaku Berdasarkan Hubungan</h4>
                    <small>Hubungan pelaku dengan korban</small>
                </div>
                <div class="card-body">
                    <div id="chart-hubungan-pelaku" class="chart-box"></div>
                </div>
            </div>
        </div>
    </div>

    <p class="text-muted small mt-4 mb-0">
        <i class="bi bi-clock me-1"></i>
        Data Kekerasan Perempuan dan Anak Kabupaten Karangasem dari Tahun 2022 hingga {{ $tahun ?? date('Y') }}.
        Sumber data: Sistem Informasi PPA Karangasem.
    </p>
</div>
@endsection

@section('js')
<script src="/assets/extensions/apexcharts/apexcharts.min.js"></script>
<script>
(function () {
    document.addEventListener('DOMContentLoaded', function () {

        // ── MASTER LABELS ─────────────────────────────────────────────
        const MASTER_KECAMATAN = [
            'Abang','Bebandem','Karangasem','Kubu',
            'Manggis','Rendang','Selat','Sidemen'
        ];

        const MASTER_BENTUK_KEKERASAN = [
            'KDRT Fisik','KDRT Psikis','Persetubuhan','Pelecehan',
            'Pemerkosaan','Penelantaran','Penganiayaan','Pencurian',
            'Bullying','TPPO (Trafficking)','Pedofilia','Ekspolitasi seksual',
            'Ekspolitasi ekonomi','Korban kejahatan ITE','Trauma Lakalantas'
        ];

        const MASTER_TEMPAT_KEJADIAN = [
            'Rumah Sendiri','Sekolah/Kampus',
            'Tempat Kerja','Sarana Umum','Daring/Elektronik'
        ];

        const MASTER_GENDER_KORBAN   = ['Perempuan','Laki-laki'];
        const MASTER_HUBUNGAN_PELAKU = ['Keluarga','Kerabat','Orang Tidak Dikenal','lainnya'];

        const MASTER_RENTANG_PEREMPUAN = [
            '0-4 thn','5-9 thn','10-14 thn','15-17 thn',
            '18-24 thn','25-34 thn','35-44 thn','45-59 thn','60+ thn'
        ];

        const MASTER_RENTANG_ANAK = [
            '0-4 thn','5-9 thn','10-14 thn','15-17 thn'
        ];

        // ── DATA DARI LARAVEL ─────────────────────────────────────────
        const rawWilayah          = @json($wilayah ?? []);
        const rawJenisKasus       = @json($jenisKasus ?? []);
        const rawKorban           = @json($korban ?? []);
        const rawTempatKejadian   = @json($tempatKejadian ?? []);
        const rawHubunganPelaku   = @json($hubunganPelaku ?? []);
        const rawBanyakKekerasan  = @json($banyakKekerasan ?? []);
        const rawRentangPerempuan = @json($rentangUmurPerempuan ?? []);
        const rawRentangAnak      = @json($rentangUmurAnak ?? []);

        // ── HELPERS ───────────────────────────────────────────────────
        function cleanText(v) {
            return String(v ?? '').trim().toLowerCase();
        }

        function normalizeSeries(masterLabels, rawData, labelKey, valueKey = 'total') {
            return masterLabels.map(label => {
                const found = rawData.find(item => cleanText(item[labelKey]) === cleanText(label));
                return found ? Number(found[valueKey] ?? 0) : 0;
            });
        }

        function normalizeMatrix(masterXLabels, masterSeriesLabels, rawData, xKey, seriesKey, valueKey = 'total') {
            return masterSeriesLabels.map(seriesLabel => ({
                name: seriesLabel,
                data: masterXLabels.map(xLabel => {
                    const found = rawData.find(item =>
                        cleanText(item[xKey])      === cleanText(xLabel) &&
                        cleanText(item[seriesKey]) === cleanText(seriesLabel)
                    );
                    return found ? Number(found[valueKey] ?? 0) : 0;
                })
            }));
        }

        function isDarkTheme() {
            return document.documentElement.getAttribute('data-bs-theme') === 'dark'
                || document.body.classList.contains('theme-dark')
                || document.body.classList.contains('dark')
                || localStorage.getItem('theme') === 'dark';
        }

        function chartTextColor()  { return isDarkTheme() ? '#e5e7eb' : '#374151'; }
        function chartMutedColor() { return isDarkTheme() ? '#cbd5e1' : '#6b7280'; }
        function chartGridColor()  { return isDarkTheme() ? '#374151' : '#e5e7eb'; }

        function baseOptions() {
            return {
                chart: {
                    fontFamily: 'Nunito, Inter, system-ui, sans-serif',
                    foreColor: chartTextColor(),
                    toolbar: { show: true }
                },
                grid: { borderColor: chartGridColor(), strokeDashArray: 4 },
                legend: { position: 'top', labels: { colors: chartTextColor() } },
                tooltip: { theme: isDarkTheme() ? 'dark' : 'light' },
                noData: {
                    text: 'Belum ada data',
                    align: 'center',
                    verticalAlign: 'middle',
                    style: { color: chartMutedColor(), fontSize: '14px' }
                }
            };
        }

        // ← SAFE RENDER: skip jika element tidak ada di halaman ini
        function renderChart(selector, options) {
            const el = document.querySelector(selector);
            if (!el) return;
            new ApexCharts(el, options).render();
        }

        // ── NORMALISASI DATA ──────────────────────────────────────────
        const wilayahData           = normalizeSeries(MASTER_KECAMATAN, rawWilayah, 'kecamatan');
        const seriesBentukKekerasan = normalizeMatrix(MASTER_BENTUK_KEKERASAN, MASTER_KECAMATAN, rawJenisKasus, 'jenis_kasus', 'kecamatan');
        const korbanGenderData      = normalizeSeries(MASTER_GENDER_KORBAN, rawKorban, 'gender_korban');
        const tempatKasusData       = normalizeSeries(MASTER_TEMPAT_KEJADIAN, rawTempatKejadian, 'lokasi_spesifik');
        const hubunganPelakuData    = normalizeSeries(MASTER_HUBUNGAN_PELAKU, rawHubunganPelaku, 'hubungan_pelaku');
        const rentangPerempuanData  = normalizeSeries(MASTER_RENTANG_PEREMPUAN, rawRentangPerempuan, 'rentang');
        const rentangAnakData       = normalizeSeries(MASTER_RENTANG_ANAK, rawRentangAnak, 'rentang');

        // ── RENDER CHARTS ─────────────────────────────────────────────

        // 1. Wilayah
        renderChart('#chart-wilayah', {
            ...baseOptions(),
            chart: { ...baseOptions().chart, type: 'bar', height: 365 },
            series: [{ name: 'Jumlah Kasus', data: wilayahData }],
            xaxis: {
                categories: MASTER_KECAMATAN,
                labels: { rotate: -35, style: { colors: chartTextColor() } }
            },
            yaxis: {
                min: 0, forceNiceScale: true,
                title: { text: 'Jumlah Kasus', style: { color: chartMutedColor() } },
                labels: { style: { colors: chartTextColor() } }
            },
            plotOptions: { bar: { borderRadius: 6, columnWidth: '45%' } },
            colors: ['#435ebe'],
            dataLabels: { enabled: true }
        });

        // 2. Bentuk Kekerasan (X = jenis kasus, series = per kecamatan)
        renderChart('#chart-bentuk-kekerasan', {
            ...baseOptions(),
            chart: { ...baseOptions().chart, type: 'bar', height: 430 },
            series: seriesBentukKekerasan,
            xaxis: {
                categories: MASTER_BENTUK_KEKERASAN,
                title: { text: 'Jenis Kasus', style: { color: chartMutedColor() } },
                labels: {
                    rotate: -40,
                    style: { colors: chartTextColor(), fontSize: '11px' },
                    trim: true,
                    maxHeight: 80
                }
            },
            yaxis: {
                min: 0, forceNiceScale: true,
                title: { text: 'Jumlah Kasus', style: { color: chartMutedColor() } },
                labels: { style: { colors: chartTextColor() } }
            },
            plotOptions: { bar: { borderRadius: 4, columnWidth: '65%' } },
            dataLabels: { enabled: false },
            tooltip: { shared: true, intersect: false, theme: isDarkTheme() ? 'dark' : 'light' }
        });

        // 3. Korban Gender (Donut)
        renderChart('#chart-korban-gender', {
            ...baseOptions(),
            chart: { ...baseOptions().chart, type: 'donut', height: 365 },
            series: korbanGenderData,
            labels: MASTER_GENDER_KORBAN,
            colors: ['#ef4444','#435ebe'],
            legend: { position: 'bottom', labels: { colors: chartTextColor() } },
            dataLabels: { enabled: true }
        });

        // 4. Rentang Umur Korban Perempuan
        renderChart('#chart-rentang-perempuan', {
            ...baseOptions(),
            chart: { ...baseOptions().chart, type: 'line', height: 365 },
            series: [{ name: 'Jumlah Korban Perempuan', data: rentangPerempuanData }],
            xaxis: {
                categories: MASTER_RENTANG_PEREMPUAN,
                title: { text: 'Rentang Usia', style: { color: chartMutedColor() } },
                labels: { style: { colors: chartTextColor() } }
            },
            yaxis: {
                min: 0, forceNiceScale: true,
                title: { text: 'Jumlah Korban', style: { color: chartMutedColor() } },
                labels: { style: { colors: chartTextColor() } }
            },
            stroke: { width: 3, curve: 'smooth' },
            markers: {
                strokeColors: '#ef4444', strokeWidth: 3,
                hover: { size: 8 }
            },
            colors: ['#ef4444'],
            dataLabels: {
                enabled: true,
                style: { fontSize: '11px', colors: [chartTextColor()] },
                background: { enabled: false }
            },
        });

        // 5. Rentang Umur Korban Anak
        renderChart('#chart-rentang-anak', {
            ...baseOptions(),
            chart: { ...baseOptions().chart, type: 'line', height: 365 },
            series: [{ name: 'Jumlah Korban Anak', data: rentangAnakData }],
            xaxis: {
                categories: MASTER_RENTANG_ANAK,
                title: { text: 'Rentang Usia (≤ 17 tahun)', style: { color: chartMutedColor() } },
                labels: { style: { colors: chartTextColor() } }
            },
            yaxis: {
                min: 0, forceNiceScale: true,
                title: { text: 'Jumlah Korban', style: { color: chartMutedColor() } },
                labels: { style: { colors: chartTextColor() } }
            },
            stroke: { width: 3, curve: 'smooth' },
            markers: {
                strokeColors: '#435ebe', strokeWidth: 3,
                hover: { size: 8 }
            },
            colors: ['#435ebe'],
            dataLabels: {
                enabled: true,
                style: { fontSize: '11px', colors: [chartTextColor()] },
                background: { enabled: false }
            },
        });

        // 6. Tempat Kasus
        renderChart('#chart-tempat-kasus', {
            ...baseOptions(),
            chart: { ...baseOptions().chart, type: 'bar', height: 365 },
            series: [{ name: 'Jumlah Kasus', data: tempatKasusData }],
            xaxis: {
                categories: MASTER_TEMPAT_KEJADIAN,
                labels: { rotate: -25, style: { colors: chartTextColor() } }
            },
            yaxis: {
                min: 0, forceNiceScale: true,
                labels: { style: { colors: chartTextColor() } }
            },
            plotOptions: { bar: { borderRadius: 6, columnWidth: '45%' } },
            colors: ['#10b981'],
            dataLabels: { enabled: true }
        });

        // 7. Hubungan Pelaku
        renderChart('#chart-hubungan-pelaku', {
            ...baseOptions(),
            chart: { ...baseOptions().chart, type: 'bar', height: 365 },
            series: [{ name: 'Jumlah Pelaku', data: hubunganPelakuData }],
            xaxis: {
                categories: MASTER_HUBUNGAN_PELAKU,
                labels: { rotate: -35, style: { colors: chartTextColor() } }
            },
            yaxis: {
                min: 0, forceNiceScale: true,
                labels: { style: { colors: chartTextColor() } }
            },
            plotOptions: { bar: { borderRadius: 6, columnWidth: '45%' } },
            colors: ['#f59e0b'],
            dataLabels: { enabled: true }
        });

        // Catatan: chart #chart-tempat-korban dan #chart-tempat-korban
        // tidak ada di halaman publik, renderChart akan otomatis skip.

    });
})();
</script>
@endsection