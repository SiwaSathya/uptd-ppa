@extends('template')

@section('css')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Knowledge - UPTD PPA Karangasem</title>
    <link rel="shortcut icon" href="/assets/compiled/svg/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="/assets/compiled/css/app.css">
    <link rel="stylesheet" href="/assets/compiled/css/app-dark.css">

    <style>
        .kn-section {
            background: #f8f9fc;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 22px 26px;
            margin-bottom: 20px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        }
        [data-bs-theme="dark"] .kn-section,
        .layout-dark .kn-section {
            background: #1e2433;
            border-color: #2e3650;
            box-shadow: none;
        }
        .kn-title {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            color: #6b7280;
            margin-bottom: 16px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        [data-bs-theme="dark"] .kn-title,
        .layout-dark .kn-title { color: #9ca3b0; border-bottom-color: #2e3650; }
        .kn-title-left { display: flex; align-items: center; gap: 8px; }
        .kn-title .icon-box {
            width: 28px; height: 28px; min-width: 28px;
            background: #eff2ff; color: #435ebe;
            border-radius: 8px; display: flex;
            align-items: center; justify-content: center;
            line-height: 0; font-size: 0; flex-shrink: 0;
        }
        .kn-title .icon-box .bi { font-size: 14px; line-height: 1; display: flex; align-items: center; }
        [data-bs-theme="dark"] .kn-title .icon-box,
        .layout-dark .kn-title .icon-box { background: rgba(67,94,190,0.18); color: #a5b4fc; }

        .item-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 14px 16px;
            margin-bottom: 10px;
        }
        [data-bs-theme="dark"] .item-card,
        .layout-dark .item-card { background: #252d3d; border-color: #2e3650; }
        .item-card-title { font-weight: 600; font-size: 13px; color: #1f2937; margin-bottom: 4px; }
        [data-bs-theme="dark"] .item-card-title,
        .layout-dark .item-card-title { color: #e2e6f0; }
        .item-card-body { font-size: 12px; color: #6b7280; line-height: 1.55; }
        [data-bs-theme="dark"] .item-card-body,
        .layout-dark .item-card-body { color: #9ca3b0; }

        .item-actions { display: flex; gap: 6px; margin-top: 10px; }
        .btn-act-edit {
            font-size: 12px; padding: 4px 12px; border-radius: 7px;
            border: 1px solid #6c8be8; color: #6c8be8; background: transparent; transition: all .15s;
        }
        .btn-act-edit:hover { background: #6c8be8; color: #fff; }
        [data-bs-theme="dark"] .btn-act-edit,
        .layout-dark .btn-act-edit { border-color: #7a96f0; color: #a5b8fb; }
        [data-bs-theme="dark"] .btn-act-edit:hover,
        .layout-dark .btn-act-edit:hover { background: #4a63c8; color: #fff; border-color: #4a63c8; }
        .btn-act-delete {
            font-size: 12px; padding: 4px 12px; border-radius: 7px;
            border: 1px solid #9ca3af; color: #6b7280; background: transparent; transition: all .15s;
        }
        .btn-act-delete:hover { background: #ef4444; border-color: #ef4444; color: #fff; }
        [data-bs-theme="dark"] .btn-act-delete,
        .layout-dark .btn-act-delete { border-color: #4b5568; color: #9ca3b0; }
        [data-bs-theme="dark"] .btn-act-delete:hover,
        .layout-dark .btn-act-delete:hover { background: #b91c1c; border-color: #b91c1c; color: #fff; }

        .page-header-box {
            background: linear-gradient(135deg, #435ebe 0%, #6478d4 100%);
            border-radius: 14px; padding: 20px 24px; margin-bottom: 24px; color: #fff;
        }
        .page-header-box h3 { font-weight: 800; margin-bottom: 4px; color: #fff; }
        .page-header-box p  { margin-bottom: 0; color: rgba(255,255,255,0.75); font-size: 0.9rem; }

        .modal-body textarea { min-height: 100px; }
        [data-bs-theme="dark"] .modal-content,
        .layout-dark .modal-content { background: #1e2433; border-color: #2e3650; color: #e2e6f0; }
        [data-bs-theme="dark"] .modal-content .form-control,
        [data-bs-theme="dark"] .modal-content .form-select,
        .layout-dark .modal-content .form-control,
        .layout-dark .modal-content .form-select { background: #252d3d; border-color: #2e3650; color: #e2e6f0; }
        [data-bs-theme="dark"] .modal-content label,
        .layout-dark .modal-content label { color: #c4cad8; }
        [data-bs-theme="dark"] .btn-close,
        .layout-dark .btn-close { filter: invert(1); }

        [data-bs-theme="dark"] .badge.bg-primary.bg-opacity-10,
        .layout-dark .badge.bg-primary.bg-opacity-10 {
            background: rgba(99,120,212,0.25) !important; color: #a5b4fc !important;
        }

        .btn-back {
            border-radius: 10px; border: 1px solid #9ca3af; color: #6b7280;
            background: transparent; font-size: 14px; padding: 7px 18px; transition: all .15s;
        }
        .btn-back:hover { background: #6b7280; border-color: #6b7280; color: #fff; }
        [data-bs-theme="dark"] .btn-back,
        .layout-dark .btn-back { border-color: #4b5568; color: #9ca3b0; }
        [data-bs-theme="dark"] .btn-back:hover,
        .layout-dark .btn-back:hover { background: #4b5568; border-color: #4b5568; color: #fff; }

        /* ── Panduan Keamanan — tag kategori ── */
        .kategori-tag {
            display: inline-flex; align-items: center;
            background: rgba(67,94,190,0.1);
            color: #435ebe; border: 1px solid rgba(67,94,190,0.2);
            border-radius: 50px; padding: 2px 10px;
            font-size: 11px; font-weight: 600; margin: 2px 2px 2px 0;
        }
        [data-bs-theme="dark"] .kategori-tag,
        .layout-dark .kategori-tag {
            background: rgba(99,120,212,0.2); color: #a5b4fc; border-color: rgba(99,120,212,0.3);
        }

        /* Input kategori dinamis */
        .kategori-input-wrap { display: flex; flex-direction: column; gap: 8px; }
        .kategori-input-row { display: flex; gap: 8px; align-items: center; }
        .kategori-input-row input { flex: 1; }
        .btn-remove-kategori {
            width: 32px; height: 32px; border-radius: 8px; border: 1px solid #ef4444;
            color: #ef4444; background: transparent; display: flex;
            align-items: center; justify-content: center; flex-shrink: 0;
            cursor: pointer; transition: all .15s; font-size: 14px; padding: 0;
        }
        .btn-remove-kategori:hover { background: #ef4444; color: #fff; }
        .btn-add-kategori {
            font-size: 12px; padding: 5px 14px; border-radius: 8px;
            border: 1px dashed #435ebe; color: #435ebe; background: transparent;
            cursor: pointer; transition: all .15s; width: fit-content;
        }
        .btn-add-kategori:hover { background: rgba(67,94,190,0.08); }

        /* Panduan detail grid */
        .panduan-detail {
            display: grid; grid-template-columns: 1fr 1fr;
            gap: 8px; margin-top: 8px;
        }
        @media (max-width: 600px) { .panduan-detail { grid-template-columns: 1fr; } }
        .panduan-detail-item {
            background: rgba(67,94,190,0.05);
            border: 1px solid rgba(67,94,190,0.1);
            border-radius: 8px; padding: 8px 12px;
        }
        [data-bs-theme="dark"] .panduan-detail-item,
        .layout-dark .panduan-detail-item {
            background: rgba(67,94,190,0.08); border-color: rgba(67,94,190,0.15);
        }
        .panduan-detail-label {
            font-size: 10px; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.05em; color: #435ebe; margin-bottom: 3px;
        }
        [data-bs-theme="dark"] .panduan-detail-label,
        .layout-dark .panduan-detail-label { color: #a5b4fc; }
        .panduan-detail-value { font-size: 12px; color: #374151; line-height: 1.5; }
        [data-bs-theme="dark"] .panduan-detail-value,
        .layout-dark .panduan-detail-value { color: #c4cad8; }
    </style>
@endsection

@section('main')

<div class="page-header-box">
    <h3><i class="bi bi-journal-text me-2"></i>Kelola Knowledge Publik</h3>
    <p>Edit konten yang ditampilkan di halaman publik UPTD PPA Karangasem</p>
</div>

<div class="page-content">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" style="border-radius:10px;">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" style="border-radius:10px;">
            <i class="bi bi-x-circle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ── JENIS KASUS ── --}}
    <div class="kn-section">
        <div class="kn-title">
            <div class="kn-title-left">
                <span class="icon-box"><i class="bi bi-shield-exclamation"></i></span>
                Jenis-Jenis Kasus
            </div>
            <button class="btn btn-sm btn-primary" style="border-radius:8px;"
                    data-bs-toggle="modal" data-bs-target="#modalTambahJenis">
                <i class="bi bi-plus me-1"></i> Tambah
            </button>
        </div>
        @forelse($jenisKasusList as $item)
        <div class="item-card">
            <div class="item-card-title">{{ $item->jenis_kasus }}</div>
            <div class="item-card-body">{{ Str::limit($item->pengertian, 120) }}</div>
            @if($item->aksi)
                <span class="badge bg-primary bg-opacity-10 text-primary mt-1" style="font-size:11px;">{{ $item->aksi }}</span>
            @endif
            <div class="item-actions">
                <button class="btn-act-edit"
                    onclick="editJenis({{ $item->id }}, {{ json_encode($item->jenis_kasus) }}, {{ json_encode($item->pengertian) }}, {{ json_encode($item->aksi) }})">
                    <i class="bi bi-pencil me-1"></i> Edit
                </button>
                <form action="{{ route('seting.jenis.destroy', $item->id) }}" method="POST"
                      onsubmit="return confirm('Yakin hapus jenis kasus ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-act-delete"><i class="bi bi-trash me-1"></i> Hapus</button>
                </form>
            </div>
        </div>
        @empty
            <p class="text-muted text-center py-3">Belum ada data jenis kasus.</p>
        @endforelse
    </div>

    {{-- ── SOP ── --}}
    <div class="kn-section">
        <div class="kn-title">
            <div class="kn-title-left">
                <span class="icon-box"><i class="bi bi-list-ol"></i></span>
                SOP (Tata Cara Pelaporan)
            </div>
            <button class="btn btn-sm btn-primary" style="border-radius:8px;"
                    data-bs-toggle="modal" data-bs-target="#modalTambahSop">
                <i class="bi bi-plus me-1"></i> Tambah
            </button>
        </div>
        @forelse($sopList as $item)
        <div class="item-card">
            <div class="item-card-title">{{ $item->sop }}</div>
            <div class="item-actions">
                <button class="btn-act-edit"
                    onclick="editSop({{ $item->id }}, {{ json_encode($item->sop) }})">
                    <i class="bi bi-pencil me-1"></i> Edit
                </button>
                <form action="{{ route('seting.sop.destroy', $item->id) }}" method="POST"
                      onsubmit="return confirm('Yakin hapus SOP ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-act-delete"><i class="bi bi-trash me-1"></i> Hapus</button>
                </form>
            </div>
        </div>
        @empty
            <p class="text-muted text-center py-3">Belum ada data SOP.</p>
        @endforelse
    </div>

    {{-- ── UNDANG-UNDANG ── --}}
    <div class="kn-section">
        <div class="kn-title">
            <div class="kn-title-left">
                <span class="icon-box"><i class="bi bi-book"></i></span>
                Undang-Undang
            </div>
            <button class="btn btn-sm btn-primary" style="border-radius:8px;"
                    data-bs-toggle="modal" data-bs-target="#modalTambahUU">
                <i class="bi bi-plus me-1"></i> Tambah
            </button>
        </div>
        @forelse($undangUndangList as $item)
        <div class="item-card">
            <div class="item-card-title">{{ $item->nama_uu }}</div>
            <div class="item-card-body">{{ Str::limit($item->penjelasan_uu, 120) }}</div>
            <div class="item-actions">
                <button class="btn-act-edit"
                    onclick="editUU({{ $item->id }}, {{ json_encode($item->nama_uu) }}, {{ json_encode($item->penjelasan_uu) }})">
                    <i class="bi bi-pencil me-1"></i> Edit
                </button>
                <form action="{{ route('seting.uu.destroy', $item->id) }}" method="POST"
                      onsubmit="return confirm('Yakin hapus undang-undang ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-act-delete"><i class="bi bi-trash me-1"></i> Hapus</button>
                </form>
            </div>
        </div>
        @empty
            <p class="text-muted text-center py-3">Belum ada data undang-undang.</p>
        @endforelse
    </div>

    {{-- ── FAQ ── --}}
    <div class="kn-section">
        <div class="kn-title">
            <div class="kn-title-left">
                <span class="icon-box"><i class="bi bi-question-circle"></i></span>
                FAQ
            </div>
            <button class="btn btn-sm btn-primary" style="border-radius:8px;"
                    data-bs-toggle="modal" data-bs-target="#modalTambahFaq">
                <i class="bi bi-plus me-1"></i> Tambah
            </button>
        </div>
        @forelse($faqList as $item)
        <div class="item-card">
            <div class="item-card-title">{{ $item->pertanyaan }}</div>
            <div class="item-card-body">{{ Str::limit($item->jawaban, 120) }}</div>
            <div class="item-actions">
                <button class="btn-act-edit"
                    onclick="editFaq({{ $item->id }}, {{ json_encode($item->pertanyaan) }}, {{ json_encode($item->jawaban) }})">
                    <i class="bi bi-pencil me-1"></i> Edit
                </button>
                <form action="{{ route('seting.faq.destroy', $item->id) }}" method="POST"
                      onsubmit="return confirm('Yakin hapus FAQ ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-act-delete"><i class="bi bi-trash me-1"></i> Hapus</button>
                </form>
            </div>
        </div>
        @empty
            <p class="text-muted text-center py-3">Belum ada data FAQ.</p>
        @endforelse
    </div>

    {{-- ── PANDUAN KEAMANAN ── --}}
    <div class="kn-section">
        <div class="kn-title">
            <div class="kn-title-left">
                <span class="icon-box"><i class="bi bi-lock-fill"></i></span>
                Panduan Keamanan
            </div>
            <button class="btn btn-sm btn-primary" style="border-radius:8px;"
                    data-bs-toggle="modal" data-bs-target="#modalTambahPanduan">
                <i class="bi bi-plus me-1"></i> Tambah
            </button>
        </div>

        @forelse($panduanList as $item)
        <div class="item-card">
            {{-- Kategori tags --}}
            <div class="mb-2">
                @foreach($item->kategori ?? [] as $kat)
                    <span class="kategori-tag"><i class="bi bi-tag-fill me-1"></i>{{ $kat }}</span>
                @endforeach
            </div>

            {{-- Detail grid --}}
            <div class="panduan-detail">
                @if($item->tindakan_keamanan)
                <div class="panduan-detail-item">
                    <div class="panduan-detail-label"><i class="bi bi-shield-check me-1"></i>Tindakan Keamanan</div>
                    <div class="panduan-detail-value">{{ Str::limit($item->tindakan_keamanan, 100) }}</div>
                </div>
                @endif
                @if($item->preservasi_bukti)
                <div class="panduan-detail-item">
                    <div class="panduan-detail-label"><i class="bi bi-archive me-1"></i>Preservasi Bukti</div>
                    <div class="panduan-detail-value">{{ Str::limit($item->preservasi_bukti, 100) }}</div>
                </div>
                @endif
                @if($item->edukasi)
                <div class="panduan-detail-item" style="grid-column: span 2;">
                    <div class="panduan-detail-label"><i class="bi bi-mortarboard me-1"></i>Edukasi</div>
                    <div class="panduan-detail-value">{{ Str::limit($item->edukasi, 150) }}</div>
                </div>
                @endif
            </div>

            <div class="item-actions mt-3">
                <button class="btn-act-edit"
                    onclick="editPanduan(
                        {{ $item->id }},
                        {{ json_encode($item->kategori ?? []) }},
                        {{ json_encode($item->tindakan_keamanan) }},
                        {{ json_encode($item->preservasi_bukti) }},
                        {{ json_encode($item->edukasi) }}
                    )">
                    <i class="bi bi-pencil me-1"></i> Edit
                </button>
                <form action="{{ route('seting.panduan.destroy', $item->id) }}" method="POST"
                      onsubmit="return confirm('Yakin hapus panduan keamanan ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-act-delete"><i class="bi bi-trash me-1"></i> Hapus</button>
                </form>
            </div>
        </div>
        @empty
            <p class="text-muted text-center py-3">Belum ada data panduan keamanan.</p>
        @endforelse
    </div>

    <div class="text-end mb-4">
        <a href="{{ route('seting.index') }}" class="btn-back">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Pengaturan
        </a>
    </div>

</div>

{{-- ══ MODAL JENIS KASUS ══ --}}
<div class="modal fade" id="modalTambahJenis" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius:14px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="titleJenis">Tambah Jenis Kasus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formJenis" action="{{ route('seting.jenis.store') }}" method="POST">
                @csrf
                <input type="hidden" name="_method" id="methodJenis" value="POST">
                <div class="modal-body pt-3">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Jenis Kasus <span class="text-danger">*</span></label>
                        <input type="text" name="jenis_kasus" id="inputJenis" class="form-control" placeholder="Contoh: KDRT Fisik" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pengertian <span class="text-danger">*</span></label>
                        <textarea name="pengertian" id="inputPengertian" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Aksi <span class="text-muted small">(opsional)</span></label>
                        <input type="text" name="aksi" id="inputAksi" class="form-control">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" style="border-radius:8px;"><i class="bi bi-save me-1"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ══ MODAL SOP ══ --}}
<div class="modal fade" id="modalTambahSop" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius:14px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="titleSop">Tambah SOP</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formSop" action="{{ route('seting.sop.store') }}" method="POST">
                @csrf
                <input type="hidden" name="_method" id="methodSop" value="POST">
                <div class="modal-body pt-3">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">SOP <span class="text-danger">*</span></label>
                        <textarea name="sop" id="inputSopJudul" class="form-control" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" style="border-radius:8px;"><i class="bi bi-save me-1"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ══ MODAL UNDANG-UNDANG ══ --}}
<div class="modal fade" id="modalTambahUU" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius:14px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="titleUU">Tambah Undang-Undang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formUU" action="{{ route('seting.uu.store') }}" method="POST">
                @csrf
                <input type="hidden" name="_method" id="methodUU" value="POST">
                <div class="modal-body pt-3">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Undang-Undang <span class="text-danger">*</span></label>
                        <input type="text" name="nama_uu" id="inputUUJudul" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Penjelasan <span class="text-danger">*</span></label>
                        <textarea name="penjelasan_uu" id="inputUUIsi" class="form-control" rows="5" required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" style="border-radius:8px;"><i class="bi bi-save me-1"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ══ MODAL FAQ ══ --}}
<div class="modal fade" id="modalTambahFaq" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius:14px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="titleFaq">Tambah FAQ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formFaq" action="{{ route('seting.faq.store') }}" method="POST">
                @csrf
                <input type="hidden" name="_method" id="methodFaq" value="POST">
                <div class="modal-body pt-3">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pertanyaan <span class="text-danger">*</span></label>
                        <input type="text" name="pertanyaan" id="inputFaqPertanyaan" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Jawaban <span class="text-danger">*</span></label>
                        <textarea name="jawaban" id="inputFaqJawaban" class="form-control" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" style="border-radius:8px;"><i class="bi bi-save me-1"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ══ MODAL PANDUAN KEAMANAN ══ --}}
<div class="modal fade" id="modalTambahPanduan" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius:14px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="titlePanduan">Tambah Panduan Keamanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formPanduan" action="{{ route('seting.panduan.store') }}" method="POST">
                @csrf
                <input type="hidden" name="_method" id="methodPanduan" value="POST">
                <div class="modal-body pt-3">

                    {{-- Kategori — input dinamis --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Kategori <span class="text-danger">*</span>
                            <span class="text-muted small fw-normal">(bisa lebih dari satu)</span>
                        </label>
                        <div class="kategori-input-wrap" id="kategoriWrap">
                            <div class="kategori-input-row">
                                <input type="text" name="kategori[]" class="form-control"
                                       placeholder="Contoh: KDRT, Kekerasan Seksual" required>
                                {{-- Baris pertama tidak ada tombol hapus --}}
                            </div>
                        </div>
                        <button type="button" class="btn-add-kategori mt-2" onclick="tambahKategori()">
                            <i class="bi bi-plus me-1"></i> Tambah Kategori
                        </button>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Tindakan Keamanan <span class="text-danger">*</span>
                        </label>
                        <textarea name="tindakan_keamanan" id="inputTindakan" class="form-control" rows="4"
                            placeholder="Langkah-langkah tindakan keamanan yang perlu dilakukan..." required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Preservasi Bukti <span class="text-muted small fw-normal">(opsional)</span>
                        </label>
                        <textarea name="preservasi_bukti" id="inputPreservasi" class="form-control" rows="3"
                            placeholder="Cara menjaga dan melestarikan bukti..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Edukasi <span class="text-muted small fw-normal">(opsional)</span>
                        </label>
                        <textarea name="edukasi" id="inputEdukasi" class="form-control" rows="3"
                            placeholder="Informasi edukasi terkait panduan ini..."></textarea>
                    </div>

                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" style="border-radius:8px;">
                        <i class="bi bi-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<footer><div class="footer clearfix mb-0 text-muted"></div></footer>
@endsection

@section('js')
<script src="/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Solusi untuk error aria-hidden dan getBoundingClientRect pada Modal
        if (typeof bootstrap !== 'undefined') {
            bootstrap.Modal.prototype._enforceFocus = function() {};
        }
    });
</script>
<script>
    // Auto hide alert
    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(el => {
            bootstrap.Alert.getOrCreateInstance(el)?.close();
        });
    }, 4000);

    // ── Edit Jenis Kasus ──
    function editJenis(id, jenis, pengertian, aksi) {
        document.getElementById('titleJenis').textContent = 'Edit Jenis Kasus';
        document.getElementById('formJenis').action       = `/seting/jenis-kasus/${id}`;
        document.getElementById('methodJenis').value      = 'PUT';
        document.getElementById('inputJenis').value       = jenis;
        document.getElementById('inputPengertian').value  = pengertian;
        document.getElementById('inputAksi').value        = aksi || '';
        new bootstrap.Modal(document.getElementById('modalTambahJenis')).show();
    }
    document.getElementById('modalTambahJenis').addEventListener('hidden.bs.modal', function () {
        document.getElementById('titleJenis').textContent = 'Tambah Jenis Kasus';
        document.getElementById('formJenis').action       = '{{ route("seting.jenis.store") }}';
        document.getElementById('methodJenis').value      = 'POST';
        document.getElementById('formJenis').reset();
    });

    // ── Edit SOP ──
    function editSop(id, sop) {
        document.getElementById('titleSop').textContent = 'Edit SOP';
        document.getElementById('formSop').action       = `/seting/sop/${id}`;
        document.getElementById('methodSop').value      = 'PUT';
        document.getElementById('inputSopJudul').value  = sop;
        new bootstrap.Modal(document.getElementById('modalTambahSop')).show();
    }
    document.getElementById('modalTambahSop').addEventListener('hidden.bs.modal', function () {
        document.getElementById('titleSop').textContent = 'Tambah SOP';
        document.getElementById('formSop').action       = '{{ route("seting.sop.store") }}';
        document.getElementById('methodSop').value      = 'POST';
        document.getElementById('formSop').reset();
    });

    // ── Edit UU ──
    function editUU(id, nama_uu, penjelasan_uu) {
        document.getElementById('titleUU').textContent = 'Edit Undang-Undang';
        document.getElementById('formUU').action       = `/seting/uu/${id}`;
        document.getElementById('methodUU').value      = 'PUT';
        document.getElementById('inputUUJudul').value  = nama_uu;
        document.getElementById('inputUUIsi').value    = penjelasan_uu;
        new bootstrap.Modal(document.getElementById('modalTambahUU')).show();
    }
    document.getElementById('modalTambahUU').addEventListener('hidden.bs.modal', function () {
        document.getElementById('titleUU').textContent = 'Tambah Undang-Undang';
        document.getElementById('formUU').action       = '{{ route("seting.uu.store") }}';
        document.getElementById('methodUU').value      = 'POST';
        document.getElementById('formUU').reset();
    });

    // ── Edit FAQ ──
    function editFaq(id, pertanyaan, jawaban) {
        document.getElementById('titleFaq').textContent        = 'Edit FAQ';
        document.getElementById('formFaq').action              = `/seting/faq/${id}`;
        document.getElementById('methodFaq').value             = 'PUT';
        document.getElementById('inputFaqPertanyaan').value    = pertanyaan;
        document.getElementById('inputFaqJawaban').value       = jawaban;
        new bootstrap.Modal(document.getElementById('modalTambahFaq')).show();
    }
    document.getElementById('modalTambahFaq').addEventListener('hidden.bs.modal', function () {
        document.getElementById('titleFaq').textContent = 'Tambah FAQ';
        document.getElementById('formFaq').action       = '{{ route("seting.faq.store") }}';
        document.getElementById('methodFaq').value      = 'POST';
        document.getElementById('formFaq').reset();
    });

    // ────────────────────────────────────────
    // ── PANDUAN KEAMANAN ──
    // ────────────────────────────────────────

    // Tambah baris input kategori
    function tambahKategori(nilai = '') {
        const wrap = document.getElementById('kategoriWrap');
        const row  = document.createElement('div');
        row.className = 'kategori-input-row';
        row.innerHTML = `
            <input type="text" name="kategori[]" class="form-control"
                   placeholder="Tambah kategori..." value="${escHtml(nilai)}">
            <button type="button" class="btn-remove-kategori" onclick="this.parentElement.remove()">
                <i class="bi bi-x"></i>
            </button>
        `;
        wrap.appendChild(row);
    }

    function escHtml(s) {
        return String(s || '').replace(/[&<>"']/g, c =>
            ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c])
        );
    }

    // Buka modal edit panduan
    function editPanduan(id, kategori, tindakan, preservasi, edukasi) {
        document.getElementById('titlePanduan').textContent  = 'Edit Panduan Keamanan';
        document.getElementById('formPanduan').action        = `/seting/panduan/${id}`;
        document.getElementById('methodPanduan').value       = 'PUT';
        document.getElementById('inputTindakan').value       = tindakan  || '';
        document.getElementById('inputPreservasi').value     = preservasi || '';
        document.getElementById('inputEdukasi').value        = edukasi    || '';

        // Rebuild kategori inputs
        const wrap = document.getElementById('kategoriWrap');
        wrap.innerHTML = '';

        const list = Array.isArray(kategori) ? kategori : [];
        if (list.length === 0) list.push('');

        list.forEach(function (kat, idx) {
            if (idx === 0) {
                // Baris pertama tanpa tombol hapus
                const row = document.createElement('div');
                row.className = 'kategori-input-row';
                row.innerHTML = `<input type="text" name="kategori[]" class="form-control"
                    placeholder="Contoh: KDRT" value="${escHtml(kat)}" required>`;
                wrap.appendChild(row);
            } else {
                tambahKategori(kat);
            }
        });

        new bootstrap.Modal(document.getElementById('modalTambahPanduan')).show();
    }

    // Reset modal panduan saat ditutup
    document.getElementById('modalTambahPanduan').addEventListener('hidden.bs.modal', function () {
        document.getElementById('titlePanduan').textContent = 'Tambah Panduan Keamanan';
        document.getElementById('formPanduan').action       = '{{ route("seting.panduan.store") }}';
        document.getElementById('methodPanduan').value      = 'POST';
        document.getElementById('formPanduan').reset();

        // Reset kategori ke 1 baris kosong
        const wrap = document.getElementById('kategoriWrap');
        wrap.innerHTML = `
            <div class="kategori-input-row">
                <input type="text" name="kategori[]" class="form-control"
                       placeholder="Contoh: KDRT, Kekerasan Seksual" required>
            </div>
        `;
    });
</script>
@endsection