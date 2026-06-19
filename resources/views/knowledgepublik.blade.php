@extends('bar')

@section('css')
    <link rel="shortcut icon" href="/assets/compiled/svg/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="/assets/compiled/css/app.css">
    <link rel="stylesheet" href="/assets/compiled/css/app-dark.css">
    <link rel="stylesheet" href="/assets/compiled/css/iconly.css">

    <style>
        /* Accordion toggle fix */
        .accordion-button {
            cursor: pointer !important;
            pointer-events: auto !important;
            position: relative;
            z-index: 1;
        }

        /* Dark mode: teks accordion */
        [data-bs-theme="dark"] .accordion-button,
        .layout-dark .accordion-button {
            color: #d1d5db !important;
            background-color: #1e2433 !important;
        }
        [data-bs-theme="dark"] .accordion-button:not(.collapsed),
        .layout-dark .accordion-button:not(.collapsed) {
            color: #a5b4fc !important;
            background-color: #252d3d !important;
        }
        [data-bs-theme="dark"] .accordion-body,
        .layout-dark .accordion-body {
            color: #c9cdd8 !important;
            background-color: #1a2130 !important;
            white-space: pre-line;
        }
        [data-bs-theme="dark"] .accordion-item,
        .layout-dark .accordion-item {
            border-color: #2e3650 !important;
            background-color: #1e2433 !important;
        }

        /* Light mode: kurangi brightness card */
       /* Light mode: kurangi brightness card utama */
        .card {
            background-color: #f8f9fc !important;
        }
        
        /* Sub-card panduan keamanan (default light mode) */
        .security-card {
            background-color: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            transition: transform 0.2s;
        }
        .security-card:hover {
            transform: translateY(-2px);
        }

        /* ── FIX DARK MODE: Card & Border Abu-Abu ── */
        [data-bs-theme="dark"] .card,
        .layout-dark .card {
            background-color: var(--bs-body-bg) !important;
        }

        [data-bs-theme="dark"] .security-card,
        .layout-dark .security-card {
            background-color: #1e2433 !important; /* Mengikuti warna tema gelap main card */
            border: 1px solid #374151 !important; /* Border abu-abu gelap agar tidak mencolok */
        }

        /* Mengubah warna teks deskripsi sub-card di dark mode agar kontras */
        [data-bs-theme="dark"] .security-card p,
        .layout-dark .security-card p {
            color: #9ca3af !important;
        }

        /* Dark mode: tabel */
        [data-bs-theme="dark"] .table,
        .layout-dark .table {
            color: #c9cdd8 !important;
        }
        [data-bs-theme="dark"] .table th,
        .layout-dark .table th {
            color: #a0a9be !important;
        }

        /* Dark mode: Alert & Card Panduan */
        [data-bs-theme="dark"] .alert-light-primary,
        .layout-dark .alert-light-primary {
            background-color: rgba(67, 94, 190, 0.15) !important;
            color: #a5b4fc !important;
        }
        [data-bs-theme="dark"] .alert-light-primary strong,
        .layout-dark .alert-light-primary strong {
            color: #c7d2fe !important;
        }

        /* Accordion chevron warna di dark */
        [data-bs-theme="dark"] .accordion-button::after,
        .layout-dark .accordion-button::after {
            filter: invert(0.7) sepia(0.3) saturate(2) hue-rotate(200deg);
        }
    </style>
@endsection

@section('main')
<div class="page-heading">
    <h3>Knowledge Publik</h3>
    <p class="text-muted mb-0">Informasi, Peraturan, &amp; Panduan Keamanan Publik</p>
</div>

<section class="section">

    {{-- ── PANDUAN KEAMANAN ── --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-start border-danger border-4">
                <div class="card-header d-flex align-items-center">
                    <i class="bi bi-shield-fill-check text-danger fs-3 me-3"></i>
                    <div>
                        <h4 class="card-title mb-0">Panduan Keamanan Mandiri</h4>
                        <small class="text-muted">Langkah darurat untuk perlindungan diri korban kekerasan</small>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <!-- Menghapus bg-white, diganti kontrol penuh lewat class security-card -->
                            <div class="p-3 border rounded h-100 security-card shadow-sm">
                                <h6 class="text-danger d-flex align-items-center">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i> Kondisi Darurat
                                </h6>
                                <p class="small text-muted mb-0">Jika Anda berada dalam bahaya segera, hubungi call center polisi (110) atau amankan diri ke tempat ramai/kerabat terdekat.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <!-- Menghapus bg-white -->
                            <div class="p-3 border rounded h-100 security-card shadow-sm">
                                <h6 class="text-warning d-flex align-items-center">
                                    <i class="bi bi-phone-fill me-2"></i> Keamanan Digital
                                </h6>
                                <p class="small text-muted mb-0">Hapus riwayat obrolan pelaporan ini jika HP Anda sering diperiksa oleh pelaku. Gunakan sandi pengunci aplikasi.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <!-- Menghapus bg-white -->
                            <div class="p-3 border rounded h-100 security-card shadow-sm">
                                <h6 class="text-primary d-flex align-items-center">
                                    <i class="bi bi-archive-fill me-2"></i> Amankan Bukti
                                </h6>
                                <p class="small text-muted mb-0">Simpan foto memar, tangkapan layar pesan ancaman, atau rekaman suara di tempat penyimpanan awan (cloud storage) yang rahasia.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- ── JENIS KASUS ── --}}
    <div class="row" id="basic-table">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Jenis-Jenis Kasus</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-lg table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th style="width:220px;">Jenis</th>
                                        <th>Pengertian</th>
                                        <th style="width:200px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($jenisKasusList as $item)
                                    <tr>
                                        <td class="text-bold-500">{{ $item->jenis_kasus }}</td>
                                        <td>{{ $item->pengertian }}</td>
                                        <td class="text-bold-500">{{ $item->aksi ?? '-' }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4">
                                            <i class="bi bi-inbox fs-4 d-block mb-1"></i>
                                            Belum ada data jenis kasus.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- ── SOP ── --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>SOP Penanganan Kasus</h4>
                </div>
                <div class="card-body">
                    @forelse($sopList as $item)
                    <div class="alert alert-light-primary fade show mb-3" role="alert"
                         style="border-left: 4px solid #435ebe;">
                        <div class="d-flex">
                            <i class="bi bi-info-circle-fill me-3 fs-5 mt-1 text-primary flex-shrink-0"></i>
                            <div>
                                <strong class="d-block">{{ $item->sop }}</strong>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-inbox fs-4 d-block mb-1"></i>
                        Belum ada data SOP.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>


    {{-- ── UNDANG-UNDANG ── --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Undang-Undang & Payung Hukum</h4>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">Berikut adalah peraturan perundang-undangan yang relevan untuk perlindungan perempuan dan anak:</p>

                    @forelse($undangUndangList as $item)
                    <div class="accordion mb-2">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed py-3"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapseUU{{ $item->id }}"
                                        aria-expanded="false">
                                    <i class="bi bi-book-fill me-2 text-primary"></i>
                                    {{ $item->nama_uu }}
                                </button>
                            </h2>
                            <div id="collapseUU{{ $item->id }}" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    {{ $item->penjelasan_uu }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-inbox fs-4 d-block mb-1"></i>
                        Belum ada data undang-undang.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>


    {{-- ── FAQ ── --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>FAQ (Pertanyaan Umum)</h4>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">Pertanyaan yang sering diajukan seputar layanan UPTD PPA:</p>

                    @forelse($faqList as $item)
                    <div class="accordion accordion-flush mb-1">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed py-3"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapseFaq{{ $item->id }}"
                                        aria-expanded="false">
                                    <i class="bi bi-question-circle me-2 text-info"></i>
                                    {{ $item->pertanyaan }}
                                </button>
                            </h2>
                            <div id="collapseFaq{{ $item->id }}" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    {{ $item->jawaban }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-inbox fs-4 d-block mb-1"></i>
                        Belum ada data FAQ.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

</section>

<footer>
    <div class="footer clearfix mb-0 text-muted"></div>
</footer>
@endsection

@section('js')
<script src="/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
@endsection