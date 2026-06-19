@extends('template')

@section('css')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kirim Pesan - UPTD PPA Karangasem</title>

    <link rel="shortcut icon" href="/assets/compiled/svg/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="/assets/compiled/css/app.css">
    <link rel="stylesheet" href="/assets/compiled/css/app-dark.css">

    <style>
        /* ══════════════════════════════════════
           ACCENT — seragam dengan halaman lain
        ══════════════════════════════════════ */
        :root {
            --accent:       #435ebe;
            --accent-hover: #3450aa;
            --accent-shadow: rgba(67, 94, 190, 0.3);
        }

        /* ══════════════════════════════════════
           INFO ROWS
        ══════════════════════════════════════ */
        .info-row {
            display: flex;
            padding: 14px 16px;
            border-bottom: 1px solid rgba(128,128,128,0.12);
            align-items: flex-start;
            background-color: #f8f9fc;
            transition: background-color 0.2s ease;
        }
        .info-row:last-of-type { border-bottom: none; }
        .info-row:hover        { background-color: #eef1fb; }

        .info-label {
            min-width: 180px;
            font-weight: 600;
            font-size: 0.95rem;
            color: #6b7280;
        }
        .info-value {
            font-size: 0.95rem;
            color: #1f2937;
            flex-grow: 1;
            font-weight: 500;
        }

        /* dark mode info rows */
        [data-bs-theme="dark"] .info-row,
        .layout-dark .info-row {
            background-color: #252d3d;
            border-bottom-color: #2e3650;
        }
        [data-bs-theme="dark"] .info-row:hover,
        .layout-dark .info-row:hover {
            background-color: #2c3550;
        }
        [data-bs-theme="dark"] .info-label,
        .layout-dark .info-label { color: #9ca3b0; }
        [data-bs-theme="dark"] .info-value,
        .layout-dark .info-value { color: #e2e6f0; }

        /* ══════════════════════════════════════
           FORM CARD
        ══════════════════════════════════════ */
        .form-card {
            border: 2px solid var(--accent);
            border-radius: 16px;
            max-width: 700px;
            margin: 0 auto;
            background-color: #f8f9fc;
            box-shadow: 0 4px 16px rgba(67,94,190,0.08);
            overflow: hidden;
        }
        [data-bs-theme="dark"] .form-card,
        .layout-dark .form-card {
            background-color: #1e2433;
            border-color: #435ebe;
            box-shadow: 0 4px 16px rgba(0,0,0,0.3);
        }

        .form-card-header {
            background: linear-gradient(135deg, #435ebe 0%, #6478d4 100%);
            padding: 16px 24px;
        }
        .form-card-header h5 {
            color: #fff;
            margin: 0;
            font-weight: 700;
        }

        /* ══════════════════════════════════════
           TIME PICKER
        ══════════════════════════════════════ */
        .time-picker {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .time-picker select {
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 1rem;
            background-color: #fff;
            color: #1f2937;
            min-width: 70px;
            text-align: center;
        }
        .time-picker .time-label {
            font-size: 0.75rem;
            color: #6b7280;
            text-align: center;
            display: block;
            margin-top: 4px;
        }
        .time-picker .separator {
            font-size: 1.3rem;
            font-weight: bold;
            color: #1f2937;
        }
        [data-bs-theme="dark"] .time-picker select,
        .layout-dark .time-picker select {
            background-color: #252d3d;
            color: #e2e6f0;
            border-color: #2e3650;
        }
        [data-bs-theme="dark"] .time-picker .separator,
        .layout-dark .time-picker .separator { color: #e2e6f0; }
        [data-bs-theme="dark"] .time-picker .time-label,
        .layout-dark .time-picker .time-label { color: #9ca3b0; }

        /* ══════════════════════════════════════
           FORM CONTROL (date input)
        ══════════════════════════════════════ */
        [data-bs-theme="dark"] .form-control,
        .layout-dark .form-control {
            background-color: #252d3d;
            color: #e2e6f0;
            border-color: #2e3650;
        }

        /* ══════════════════════════════════════
           BUTTON KIRIM — seragam biru
        ══════════════════════════════════════ */
        .btn-kirim {
            background-color: var(--accent);
            color: #fff;
            border: none;
            border-radius: 50px;
            padding: 14px 50px;
            font-size: 1.05rem;
            font-weight: 600;
            transition: all 0.25s ease;
            box-shadow: 0 4px 10px var(--accent-shadow);
        }
        .btn-kirim:hover {
            background-color: var(--accent-hover);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px var(--accent-shadow);
        }

        /* ══════════════════════════════════════
           STATUS BADGE
        ══════════════════════════════════════ */
        .status-badge-selesai {
            background-color: #198754;
            color: #fff;
            padding: 6px 14px;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.85rem;
        }
        .status-badge-proses {
            background-color: #ffc107;
            color: #212529;
            padding: 6px 14px;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.85rem;
        }

        /* ══════════════════════════════════════
           ALERT
        ══════════════════════════════════════ */
        .alert-modern {
            border: none;
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 20px;
        }
        .alert-modern.alert-success {
            background-color: rgba(25, 135, 84, 0.1);
            color: #198754;
        }
        .alert-modern.alert-danger {
            background-color: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }

        /* ══════════════════════════════════════
           NOTIFICATION BANNER — biru seragam
        ══════════════════════════════════════ */
        .notification-banner {
            background-color: rgba(67, 94, 190, 0.08);
            border-left: 4px solid var(--accent);
            padding: 12px 16px;
            border-radius: 0 8px 8px 0;
            margin-bottom: 20px;
            color: #435ebe;
            font-size: 0.92rem;
        }
        [data-bs-theme="dark"] .notification-banner,
        .layout-dark .notification-banner {
            background-color: rgba(67, 94, 190, 0.15);
            color: #a5b4fc;
        }

        .required-dot {
            color: #dc3545;
            font-size: 1.2rem;
            line-height: 1;
            vertical-align: middle;
        }
    </style>
@endsection

@section('main')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Kirim Pesan</h3>
            </div>
        </div>
    </div>

    <div class="notification-banner">
        <i class="bi bi-telephone-fill me-2"></i>
        <strong>Informasi:</strong> Pesan akan dikirim via WhatsApp ke nomor pelapor/korban yang terdaftar.
    </div>

    @if(session('success'))
        <div class="alert alert-modern alert-success alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill fs-4 me-2"></i>
                <div class="flex-grow-1">
                    <strong>Berhasil!</strong> {{ session('success') }}
                </div>
                @if(session('wa_url'))
                    <a href="{{ session('wa_url') }}" target="_blank" class="btn btn-success btn-sm ms-3">
                        <i class="bi bi-whatsapp me-1"></i> Buka WhatsApp
                    </a>
                @endif
                <button type="button" class="btn-close ms-2" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-modern alert-danger alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-x-circle-fill fs-4 me-2"></i>
                <div class="flex-grow-1">
                    <strong>Gagal!</strong> {{ session('error') }}
                </div>
                <button type="button" class="btn-close ms-2" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-modern alert-danger alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill fs-4 me-2"></i>
                <div class="flex-grow-1">
                    <strong>Terdapat kesalahan:</strong> Mohon periksa kembali data yang diisi.
                </div>
                <button type="button" class="btn-close ms-2" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <section class="section">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card form-card">
                    <div class="form-card-header">
                        <h5><i class="bi bi-whatsapp me-2"></i>Pengiriman Informasi via WhatsApp</h5>
                    </div>
                    <div class="card-body px-4 py-4">

                        <form action="/kirim_pesan/{{ $data->id }}/send" method="POST">
                            @csrf

                            <div class="info-row">
                                <div class="info-label">ID Kasus</div>
                                <div class="info-value">{{ $data->id_kasus }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Pelapor</div>
                                <div class="info-value">{{ $data->pelapor }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Jenis Kasus</div>
                                <div class="info-value">{{ $data->jenis_kasus }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Usia Korban</div>
                                <div class="info-value">{{ $data->usia_korban }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Jenis Kelamin Korban</div>
                                <div class="info-value">{{ $data->gender_korban }}</div>
                            </div>

                            <div class="info-row align-items-center">
                                <div class="info-label">
                                    Tanggal Pertemuan<span class="required-dot">*</span>
                                </div>
                                <div class="info-value flex-grow-1">
                                    <input type="date" name="tanggal_pertemuan"
                                        class="form-control form-control-lg @error('tanggal_pertemuan') is-invalid @enderror"
                                        value="{{ old('tanggal_pertemuan') }}">
                                    @error('tanggal_pertemuan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="info-row align-items-center">
                                <div class="info-label">
                                    Waktu Pertemuan<span class="required-dot">*</span>
                                </div>
                                <div class="info-value">
                                    <div class="time-picker">
                                        <div>
                                            <select name="waktu_jam"
                                                class="form-select @error('waktu_jam') is-invalid @enderror">
                                                @for($h = 1; $h <= 12; $h++)
                                                    <option value="{{ $h }}"
                                                        {{ old('waktu_jam', date('g')) == $h ? 'selected' : '' }}>
                                                        {{ str_pad($h, 2, '0', STR_PAD_LEFT) }}
                                                    </option>
                                                @endfor
                                            </select>
                                            <span class="time-label">Jam</span>
                                        </div>
                                        <span class="separator">:</span>
                                        <div>
                                            <select name="waktu_menit"
                                                class="form-select @error('waktu_menit') is-invalid @enderror">
                                                @foreach([0,5,10,15,20,25,30,35,40,45,50,55] as $m)
                                                    <option value="{{ $m }}"
                                                        {{ old('waktu_menit', (int)date('i')) == $m ? 'selected' : '' }}>
                                                        {{ str_pad($m, 2, '0', STR_PAD_LEFT) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="time-label">Menit</span>
                                        </div>
                                        <div>
                                            <select name="waktu_ampm"
                                                class="form-select @error('waktu_ampm') is-invalid @enderror">
                                                <option value="AM" {{ old('waktu_ampm', date('A')) == 'AM' ? 'selected' : '' }}>AM</option>
                                                <option value="PM" {{ old('waktu_ampm', date('A')) == 'PM' ? 'selected' : '' }}>PM</option>
                                            </select>
                                        </div>
                                    </div>
                                    @error('waktu_jam')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="info-row">
                                <div class="info-label">Status</div>
                                <div class="info-value">
                                    @if($data->status)
                                        <span class="status-badge-selesai">
                                            <i class="bi bi-check-circle-fill me-1"></i>Selesai
                                        </span>
                                    @else
                                        <span class="status-badge-proses">
                                            <i class="bi bi-clock-fill me-1"></i>Dalam Proses
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-kirim">
                                    <i class="bi bi-whatsapp me-2 fs-5"></i>Kirim via WhatsApp
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
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
    setTimeout(() => {
        document.querySelectorAll('.alert:not(:has(a))').forEach(el => {
            bootstrap.Alert.getOrCreateInstance(el)?.close();
        });
    }, 5000);
</script>
@endsection