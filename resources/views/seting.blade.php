@extends('template')

@section('css')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Sistem - UPTD PPA Karangasem</title>

    <link rel="shortcut icon" href="/assets/compiled/svg/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="/assets/compiled/css/app.css">
    <link rel="stylesheet" href="/assets/compiled/css/app-dark.css">

    <style>
        /* ══════════════════════════════════════
           PAGE HEADER
        ══════════════════════════════════════ */
        .page-header-box {
            background: linear-gradient(135deg, #435ebe 0%, #6478d4 100%);
            border-radius: 14px;
            padding: 20px 24px;
            margin-bottom: 24px;
            color: #fff;
        }
        .page-header-box h3 { font-weight: 800; margin-bottom: 4px; color: #fff; }
        .page-header-box p  { margin-bottom: 0; color: rgba(255,255,255,0.75); font-size: 0.9rem; }

        /* ══════════════════════════════════════
           SECTION CARD
        ══════════════════════════════════════ */
        .setting-section {
            background: #f8f9fc;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 22px 26px;
            margin-bottom: 18px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        }
        [data-bs-theme="dark"] .setting-section,
        .layout-dark .setting-section {
            background: #1e2433;
            border-color: #2e3650;
            box-shadow: none;
        }

        /* ══════════════════════════════════════
           SECTION TITLE — icon center fix
        ══════════════════════════════════════ */
        .setting-section-title {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            color: #6b7280;
            margin-bottom: 18px;
            padding-bottom: 12px;
            border-bottom: 1px solid #e5e7eb;
            /* flex agar icon & teks sejajar */
            display: flex;
            align-items: center;
            gap: 8px;
        }
        [data-bs-theme="dark"] .setting-section-title,
        .layout-dark .setting-section-title {
            color: #9ca3b0;
            border-bottom-color: #2e3650;
        }

        /* Icon box — line-height:0 agar Bootstrap Icons center */
        .setting-section-title .icon-box {
            width: 28px;
            height: 28px;
            min-width: 28px;
            background: #eff2ff;
            color: #435ebe;
            border-radius: 8px;
            /* flex centering */
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 0;       /* ← kunci centering BI */
            font-size: 0;         /* reset di wrapper */
            flex-shrink: 0;
        }
        .setting-section-title .icon-box .bi {
            font-size: 14px;
            line-height: 1;
            display: flex;
            align-items: center;
        }
        [data-bs-theme="dark"] .setting-section-title .icon-box,
        .layout-dark .setting-section-title .icon-box {
            background: rgba(67,94,190,0.18);
            color: #a5b4fc;
        }

        /* ══════════════════════════════════════
           FORM LABELS
        ══════════════════════════════════════ */
        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }
        [data-bs-theme="dark"] .form-label,
        .layout-dark .form-label {
            color: #c4cad8;
        }

        /* ══════════════════════════════════════
           UPLOAD BOX
        ══════════════════════════════════════ */
        .upload-box {
            border: 1.5px dashed #d1d5db;
            border-radius: 10px;
            padding: 18px 16px;
            text-align: center;
            cursor: pointer;
            transition: border-color 0.2s, background 0.2s;
            background: #f4f6ff;
        }
        .upload-box:hover {
            border-color: #435ebe;
            background: #eef1ff;
        }
        [data-bs-theme="dark"] .upload-box,
        .layout-dark .upload-box {
            background: #252d3d;
            border-color: #2e3650;
        }
        [data-bs-theme="dark"] .upload-box:hover,
        .layout-dark .upload-box:hover {
            border-color: #435ebe;
            background: rgba(67,94,190,0.1);
        }
        .upload-box img {
            max-height: 80px;
            max-width: 180px;
            object-fit: contain;
            margin: 0 auto 8px;
            display: block;
        }
        .upload-box p {
            font-size: 12px;
            color: #9ca3af;
            margin: 0;
        }
        .upload-box input[type="file"] { display: none; }

        /* ══════════════════════════════════════
           PREVIEW CARD
        ══════════════════════════════════════ */
        .preview-card {
            background: #f8f9fc;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.04);
            position: sticky;
            top: 80px;
        }
        [data-bs-theme="dark"] .preview-card,
        .layout-dark .preview-card {
            background: #1e2433;
            border-color: #2e3650;
            box-shadow: none;
        }

        .preview-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            color: #6b7280;
            margin-bottom: 14px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        [data-bs-theme="dark"] .preview-label,
        .layout-dark .preview-label {
            color: #9ca3b0;
            border-bottom-color: #2e3650;
        }
        .preview-label .bi {
            color: #435ebe;
            font-size: 15px;
            line-height: 1;
            display: flex;
            align-items: center;
        }

        /* ══════════════════════════════════════
           KOP PREVIEW
        ══════════════════════════════════════ */
        .kop-preview-wrap {
            background: #fff;
            color: #000;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 18px 20px;
        }
        .kop-preview-wrap .kop-surat {
            display: flex;
            align-items: center;
            gap: 14px;
            border-bottom: 2.5px solid #000;
            padding-bottom: 10px;
            margin-bottom: 5px;
        }
        .kop-preview-wrap .kop-surat img {
            width: 64px; height: 64px;
            object-fit: contain; flex-shrink: 0;
        }
        .kop-preview-wrap .kop-text {
            flex: 1; text-align: center; line-height: 1.35;
        }
        .kop-preview-wrap .p-induk  { font-size: 0.65rem; font-weight: 700; text-transform: uppercase; }
        .kop-preview-wrap .p-nama   { font-size: 0.75rem; font-weight: 800; text-transform: uppercase; }
        .kop-preview-wrap .p-sub    { font-size: 0.68rem; font-weight: 700; text-transform: uppercase; }
        .kop-preview-wrap .p-alamat { font-size: 0.6rem; margin-top: 3px; color: #222; }
        .kop-preview-wrap hr { border: none; border-top: 1.5px solid #000; margin: 4px 0 12px; }
        .kop-preview-wrap .p-placeholder {
            color: #bbb; font-size: 0.72rem; text-align: center;
            padding: 10px 0; border: 1px dashed #e5e7eb; border-radius: 4px;
        }
        .kop-preview-wrap .p-ttd {
            text-align: center; margin-top: 16px; font-size: 0.72rem; color: #000;
        }
        .kop-preview-wrap .p-ttd-img {
            height: 60px; display: flex; align-items: center;
            justify-content: center; margin: 6px 0;
        }
        .kop-preview-wrap .p-ttd-img img { max-height: 60px; max-width: 130px; object-fit: contain; }
        .kop-preview-wrap .p-ttd-nama { font-weight: 700; text-decoration: underline; margin-top: 6px; font-size: 0.72rem; }
        .kop-preview-wrap .p-ttd-nip  { font-size: 0.65rem; }

        /* ══════════════════════════════════════
           INFO BOX BAWAH PREVIEW
        ══════════════════════════════════════ */
        .preview-info {
            margin-top: 12px;
            padding: 12px 14px;
            border-radius: 10px;
            background: #eef1ff;
            border: 1px solid #dde4ff;
            font-size: 11px;
            color: #5560a0;
            line-height: 1.6;
            display: flex;
            gap: 8px;
            align-items: flex-start;
        }
        [data-bs-theme="dark"] .preview-info,
        .layout-dark .preview-info {
            background: rgba(67,94,190,0.12);
            border-color: #2e3650;
            color: #9ca3b8;
        }
        .preview-info .bi {
            font-size: 14px;
            color: #435ebe;
            flex-shrink: 0;
            margin-top: 1px;
            line-height: 1;
        }
    </style>
@endsection

@section('main')

<div class="page-header-box">
    <h3><i class="bi bi-gear-fill me-2"></i>Pengaturan Sistem</h3>
    <p>Kelola kop surat, tanda tangan, dan informasi instansi yang tampil di laporan</p>
</div>

<div class="page-content">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" style="border-radius:10px;">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" style="border-radius:10px;">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> Terdapat kesalahan pada form. Silakan periksa kembali.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ══════════════════════════════════════
         FORM KOP SURAT & PREVIEW
    ══════════════════════════════════════ --}}
    <form action="{{ route('seting.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-4">

            {{-- Kolom Kiri: Form --}}
            <div class="col-lg-7">

                {{-- Kop Surat --}}
                <div class="setting-section">
                    <div class="setting-section-title">
                        <span class="icon-box"><i class="bi bi-building"></i></span>
                        Informasi Kop Surat
                    </div>
                    <div class="row g-3">

                        <div class="col-12">
                            <label class="form-label">Nama Instansi Induk <span class="text-danger">*</span></label>
                            <input type="text" name="kop_instansi_induk" id="input-instansi-induk"
                                class="form-control @error('kop_instansi_induk') is-invalid @enderror"
                                value="{{ old('kop_instansi_induk', $settings['kop_instansi_induk']) }}"
                                placeholder="Pemerintah Kabupaten Karangasem">
                            @error('kop_instansi_induk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Nama Dinas / OPD <span class="text-danger">*</span></label>
                            <textarea name="kop_dinas_nama" id="input-dinas-nama" rows="2"
                                class="form-control @error('kop_dinas_nama') is-invalid @enderror"
                                placeholder="Dinas Sosial, ...">{{ old('kop_dinas_nama', $settings['kop_dinas_nama']) }}</textarea>
                            @error('kop_dinas_nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Sub Instansi / UPTD <span class="text-danger">*</span></label>
                            <input type="text" name="kop_sub_instansi" id="input-sub-instansi"
                                class="form-control @error('kop_sub_instansi') is-invalid @enderror"
                                value="{{ old('kop_sub_instansi', $settings['kop_sub_instansi']) }}"
                                placeholder="UPTD Perlindungan Perempuan dan Anak">
                            @error('kop_sub_instansi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Alamat <span class="text-danger">*</span></label>
                            <input type="text" name="kop_alamat" id="input-alamat"
                                class="form-control @error('kop_alamat') is-invalid @enderror"
                                value="{{ old('kop_alamat', $settings['kop_alamat']) }}"
                                placeholder="Jalan Ngurah Rai No. 70 ...">
                            @error('kop_alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-envelope text-muted"></i>
                                </span>
                                <input type="email" name="kop_email" id="input-email"
                                    class="form-control border-start-0 @error('kop_email') is-invalid @enderror"
                                    value="{{ old('kop_email', $settings['kop_email']) }}"
                                    placeholder="email@instansi.go.id">
                                @error('kop_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Website</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-globe text-muted"></i>
                                </span>
                                <input type="text" name="kop_website" id="input-website"
                                    class="form-control border-start-0 @error('kop_website') is-invalid @enderror"
                                    value="{{ old('kop_website', $settings['kop_website']) }}"
                                    placeholder="http://...">
                                @error('kop_website')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Logo Instansi</label>
                            <div class="upload-box" onclick="document.getElementById('input-logo').click()">
                                <img id="preview-logo-img"
                                     src="{{ $settings['kop_logo'] ? Storage::url($settings['kop_logo']) : asset('/assets/compiled/png/logo_ppa.PNG') }}"
                                     alt="Logo" onerror="this.style.display='none'">
                                <p class="mt-2">
                                    <i class="bi bi-cloud-upload me-1"></i> Klik untuk ganti logo
                                    <span class="d-block" style="font-size:11px;margin-top:2px;">JPG/PNG, maks 2MB</span>
                                </p>
                                <input type="file" id="input-logo" name="kop_logo" accept="image/*"
                                       onchange="previewImage(this, 'preview-logo-img')">
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Tanda Tangan --}}
                <div class="setting-section">
                    <div class="setting-section-title">
                        <span class="icon-box"><i class="bi bi-pen"></i></span>
                        Tanda Tangan &amp; Pejabat
                    </div>
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Kota TTD <span class="text-danger">*</span></label>
                            <input type="text" name="ttd_kota" id="input-kota"
                                class="form-control @error('ttd_kota') is-invalid @enderror"
                                value="{{ old('ttd_kota', $settings['ttd_kota']) }}"
                                placeholder="Amlapura">
                            @error('ttd_kota')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Jabatan <span class="text-danger">*</span></label>
                            <input type="text" name="ttd_jabatan" id="input-jabatan"
                                class="form-control @error('ttd_jabatan') is-invalid @enderror"
                                value="{{ old('ttd_jabatan', $settings['ttd_jabatan']) }}"
                                placeholder="Kepala UPTD PPA ...">
                            @error('ttd_jabatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nama Pejabat <span class="text-danger">*</span></label>
                            <input type="text" name="ttd_nama" id="input-pejabat"
                                class="form-control @error('ttd_nama') is-invalid @enderror"
                                value="{{ old('ttd_nama', $settings['ttd_nama']) }}"
                                placeholder="Nama lengkap + gelar">
                            @error('ttd_nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">NIP</label>
                            <input type="text" name="ttd_nip" id="input-nip"
                                class="form-control @error('ttd_nip') is-invalid @enderror"
                                value="{{ old('ttd_nip', $settings['ttd_nip']) }}"
                                placeholder="19xxxxxx xxxxxx x xxx">
                            @error('ttd_nip')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Gambar Tanda Tangan</label>
                            <div class="upload-box" onclick="document.getElementById('input-ttd').click()">
                                <img id="preview-ttd-img"
                                     src="{{ $settings['ttd_image'] ? Storage::url($settings['ttd_image']) : '/assets/compiled/png/2.png' }}"
                                     alt="TTD" onerror="this.style.display='none'">
                                <p class="mt-2">
                                    <i class="bi bi-image me-1"></i> Klik untuk ganti tanda tangan
                                    <span class="d-block" style="font-size:11px;margin-top:2px;">PNG transparan dianjurkan, maks 2MB</span>
                                </p>
                                <input type="file" id="input-ttd" name="ttd_image" accept="image/*"
                                       onchange="previewImage(this, 'preview-ttd-img')">
                            </div>
                        </div>

                    </div>
                </div>

                <div class="d-flex justify-content-end mb-2">
                    <button type="submit" class="btn btn-success px-5 py-2" style="border-radius:10px;font-weight:600;">
                        <i class="bi bi-save me-2"></i> Simpan Kop Surat &amp; TTD
                    </button>
                </div>
            </div>

            {{-- Kolom Kanan: Preview --}}
            <div class="col-lg-5">
                <div class="preview-card">
                    <div class="preview-label">
                        <i class="bi bi-eye"></i>
                        Preview Kop Surat
                    </div>

                    <div class="kop-preview-wrap" id="kop-preview">
                        <div class="kop-surat">
                            <img id="prev-logo"
                                 src="{{ $settings['kop_logo'] ? Storage::url($settings['kop_logo']) : asset('/assets/compiled/png/logo_ppa.PNG') }}"
                                 alt="Logo" onerror="this.style.display='none'">
                            <div class="kop-text">
                                <div class="p-induk"  id="prev-induk">{{ $settings['kop_instansi_induk'] }}</div>
                                <div class="p-nama"   id="prev-dinas">{{ $settings['kop_dinas_nama'] }}</div>
                                <div class="p-sub"    id="prev-sub">{{ $settings['kop_sub_instansi'] }}</div>
                                <div class="p-alamat" id="prev-alamat">
                                    {{ $settings['kop_alamat'] }}<br>
                                    e-mail : {{ $settings['kop_email'] }}<br>
                                    laman : {{ $settings['kop_website'] }}
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="p-placeholder">[ Isi laporan akan ditampilkan di sini ]</div>
                        <div class="p-ttd">
                            <div id="prev-kota-tgl">{{ $settings['ttd_kota'] }}, {{ \Carbon\Carbon::now()->translatedFormat('j F Y') }}</div>
                            <div id="prev-jabatan">{{ $settings['ttd_jabatan'] }}</div>
                            <div class="p-ttd-img">
                                <img id="prev-ttd-img"
                                     src="{{ $settings['ttd_image'] ? Storage::url($settings['ttd_image']) : '/assets/compiled/png/2.png' }}"
                                     alt="TTD" onerror="this.style.display='none'">
                            </div>
                            <div class="p-ttd-nama" id="prev-nama">{{ $settings['ttd_nama'] }}</div>
                            <div class="p-ttd-nip"  id="prev-nip">NIP. {{ $settings['ttd_nip'] }}</div>
                        </div>
                    </div>

                    <div class="preview-info">
                        <i class="bi bi-info-circle-fill"></i>
                        <span>Preview otomatis diperbarui saat kamu mengubah isian di sebelah kiri. Gambar logo dan TTD diperbarui setelah memilih file baru.</span>
                    </div>
                </div>
            </div>

        </div>{{-- end row --}}
    </form>

    {{-- ══════════════════════════════════════
         FORM KEPALA UPTD — di luar form kop
         supaya tidak konflik submit
    ══════════════════════════════════════ --}}
    <form action="{{ route('seting.kepala.update') }}" method="POST">
        @csrf
        <div class="setting-section mt-2">
            <div class="setting-section-title">
                <span class="icon-box"><i class="bi bi-person-badge"></i></span>
                Data Kepala UPTD PPA
            </div>

            <div class="row g-3">

                <div class="col-12">
                    <label class="form-label">Nama Kepala UPTD <span class="text-danger">*</span></label>
                    <input type="text" name="nama_kepala"
                        class="form-control @error('nama_kepala') is-invalid @enderror"
                        value="{{ old('nama_kepala', $kepalaUptd->nama_kepala ?? '') }}"
                        placeholder="Contoh: Ni Nyoman Budiartini, S.Sos., M.AP">
                    @error('nama_kepala')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">NIP <span class="text-danger">*</span></label>
                    <input type="text" name="nip"
                        class="form-control @error('nip') is-invalid @enderror"
                        value="{{ old('nip', $kepalaUptd->nip ?? '') }}"
                        placeholder="19xxxxxx xxxxxx x xxx">
                    @error('nip')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">No. Telepon</label>
                    <div class="input-group">
                        <span class="input-group-text" style="background:#eef1ff;border-right:0;">
                            <i class="bi bi-telephone text-muted"></i>
                        </span>
                        <input type="text" name="no_telp"
                            class="form-control border-start-0 @error('no_telp') is-invalid @enderror"
                            value="{{ old('no_telp', $kepalaUptd->no_telp ?? '') }}"
                            placeholder="082xxxxxxxx">
                        @error('no_telp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

            </div>

            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-success px-4 py-2" style="border-radius:10px;font-weight:600;">
                    <i class="bi bi-person-check me-2"></i> Simpan Data Kepala
                </button>
            </div>
        </div>
    </form>

    {{-- Tombol ke Knowledge --}}
    <div class="text-end mt-2 mb-4">
        <a href="{{ route('seting.knowledge') }}" class="btn btn-primary px-4 py-2" style="border-radius:10px;font-weight:600;">
            <i class="bi bi-journal-text me-2"></i> Kelola Konten Knowledge Publik
        </a>
    </div>

</div>

<footer><div class="footer clearfix mb-0 text-muted"></div></footer>
@endsection

@section('js')
<script src="/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>

<script>
    function previewImage(input, targetId) {
        const file = input.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            const img = document.getElementById(targetId);
            img.src = e.target.result;
            img.style.display = 'block';
            if (targetId === 'preview-logo-img') document.getElementById('prev-logo').src = e.target.result;
            if (targetId === 'preview-ttd-img')  {
                document.getElementById('prev-ttd-img').src = e.target.result;
                document.getElementById('prev-ttd-img').style.display = 'block';
            }
        };
        reader.readAsDataURL(file);
    }

    function escHtml(s) {
        return String(s).replace(/[&<>"']/g, c =>
            ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c])
        );
    }

    function syncPreview() {
        const get = id => document.getElementById(id)?.value || '';
        document.getElementById('prev-induk').textContent    = get('input-instansi-induk') || 'Nama Instansi Induk';
        document.getElementById('prev-dinas').textContent    = get('input-dinas-nama')     || 'Nama Dinas';
        document.getElementById('prev-sub').textContent      = get('input-sub-instansi')   || 'Sub Instansi';
        document.getElementById('prev-jabatan').textContent  = get('input-jabatan')         || 'Jabatan Pejabat';
        document.getElementById('prev-nama').textContent     = get('input-pejabat')         || 'Nama Pejabat';
        document.getElementById('prev-nip').textContent      = 'NIP. ' + (get('input-nip') || '-');
        document.getElementById('prev-kota-tgl').textContent =
            (get('input-kota') || 'Kota') + ', {{ \Carbon\Carbon::now()->translatedFormat("j F Y") }}';
        const alamat  = get('input-alamat')  || 'Alamat instansi';
        const email   = get('input-email')   || 'email@instansi.go.id';
        const website = get('input-website') || 'http://...';
        document.getElementById('prev-alamat').innerHTML =
            escHtml(alamat) + '<br>e-mail : ' + escHtml(email) + '<br>laman : ' + escHtml(website);
    }

    ['input-instansi-induk','input-dinas-nama','input-sub-instansi',
     'input-alamat','input-email','input-website',
     'input-kota','input-jabatan','input-pejabat','input-nip'
    ].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.addEventListener('input', syncPreview);
    });

    syncPreview();

    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(el => {
            bootstrap.Alert.getOrCreateInstance(el)?.close();
        });
    }, 4000);
</script>
@endsection