@extends('template')

@section('css')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelaporan - UPTD PPA Karangasem</title>

    <link rel="shortcut icon" href="/assets/compiled/svg/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="/assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="/assets/compiled/css/table-datatable-jquery.css">
    <link rel="stylesheet" href="/assets/compiled/css/app.css">
    <link rel="stylesheet" href="/assets/compiled/css/app-dark.css">
@endsection

@section('main')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Form Pelaporan Detail</h3>
            </div>
        </div>
    </div>

    {{-- Alert Sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Alert Gagal --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-x-circle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Alert Validation Error --}}
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i> Terdapat kesalahan pada form. Silakan periksa kembali.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form action="/detail_laporan/{{ $data->id }}/save" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">

                                   {{-- ID Kasus (readonly) --}}
                                    <div class="col-md-6 col-12 mb-3">
                                        <div class="form-group">
                                            <label>ID Kasus</label>
                                            <input type="text" class="form-control"
                                                value="{{ $data->id_kasus_formatted}}"
                                                readonly>
                                        </div>
                                    </div>

                                    {{-- Pelapor --}}
                                    <div class="col-md-6 col-12 mb-3">
                                        <div class="form-group">
                                            <label>Pelapor</label>
                                            <select class="form-select @error('pelapor') is-invalid @enderror" name="pelapor">
                                                @foreach(['Korban','Keluarga','Kerabat','Instansi'] as $opt)
                                                    <option value="{{ $opt }}" {{ old('pelapor', $data->pelapor) == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                                @endforeach
                                            </select>
                                            @error('pelapor')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Nomor Pelapor --}}
                                    <div class="col-md-6 col-12 mb-3">
                                        <div class="form-group">
                                            <label>Nomor Pelapor</label>
                                            <input type="text" name="user_number"
                                                class="form-control @error('user_number') is-invalid @enderror"
                                                value="{{ old('user_number', $data->user_number) }}"
                                                placeholder="081234563571">
                                            @error('user_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Jenis Kasus --}}
                                    <div class="col-md-6 col-12 mb-3">
                                        <div class="form-group">
                                            <label>Jenis Kasus</label>
                                            <select name="jenis_kasus" class="form-select @error('jenis_kasus') is-invalid @enderror">
                                                @foreach(['KDRT Fisik','KDRT Psikis','Persetubuhan','Pelecehan','Pemerkosaan','Penelantaran','Penganiayaan','Pencurian','Bullying','TPPO (Trafficking)','Pedofilia','Ekspolitasi seksual','Ekspolitasi ekonomi','Korban kejahatan ITE','Trauma Lakalantas'] as $opt)
                                                    <option value="{{ $opt }}" {{ old('jenis_kasus', $data->jenis_kasus) == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                                @endforeach
                                            </select>
                                            @error('jenis_kasus')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Usia Korban --}}
                                    <div class="col-md-6 col-12 mb-3">
                                        <div class="form-group">
                                            <label>Usia Korban</label>
                                            <input type="number" name="usia_korban"
                                                class="form-control @error('usia_korban') is-invalid @enderror"
                                                value="{{ old('usia_korban', $data->usia_korban) }}"
                                                placeholder="20">
                                            @error('usia_korban')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Hubungan Pelaku --}}
                                    <div class="col-md-6 col-12 mb-3">
                                        <div class="form-group">
                                            <label>Hubungan Pelaku dengan Korban</label>
                                            <select name="hubungan_pelaku" class="form-select @error('hubungan_pelaku') is-invalid @enderror">
                                                @foreach(['Keluarga','Kerabat','Orang Tidak Dikenal'] as $opt)
                                                    <option value="{{ $opt }}" {{ old('hubungan_pelaku', $data->hubungan_pelaku) == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                                @endforeach
                                            </select>
                                            @error('hubungan_pelaku')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Nama Korban --}}
                                    <div class="col-md-6 col-12 mb-3">
                                        <div class="form-group">
                                            <label>Nama Korban</label>
                                            <input type="text" name="nama_korban"
                                                class="form-control @error('nama_korban') is-invalid @enderror"
                                                value="{{ old('nama_korban', $data->nama_korban) }}"
                                                placeholder="nama">
                                            @error('nama_korban')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Nama Pelaku --}}
                                    <div class="col-md-6 col-12 mb-3">
                                        <div class="form-group">
                                            <label>Nama Pelaku</label>
                                            <input type="text" name="nama_pelaku"
                                                class="form-control @error('nama_pelaku') is-invalid @enderror"
                                                value="{{ old('nama_pelaku', $data->nama_pelaku) }}"
                                                placeholder="nama">
                                            @error('nama_pelaku')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Jenis Kelamin Korban --}}
                                    <div class="col-md-6 col-12 mb-3">
                                        <div class="form-group">
                                            <label class="form-label d-block">Jenis Kelamin Korban</label>
                                            @foreach(['Laki-laki','Perempuan'] as $opt)
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input @error('gender_korban') is-invalid @enderror"
                                                        type="radio" name="gender_korban"
                                                        value="{{ $opt }}"
                                                        {{ old('gender_korban', $data->gender_korban) == $opt ? 'checked' : '' }}>
                                                    <label class="form-check-label">{{ $opt }}</label>
                                                </div>
                                            @endforeach
                                            @error('gender_korban')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Jenis Kelamin Pelaku --}}
                                    <div class="col-md-6 col-12 mb-3">
                                        <div class="form-group">
                                            <label class="form-label d-block">Jenis Kelamin Pelaku</label>
                                            @foreach(['Laki-laki','Perempuan'] as $opt)
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input @error('gender_pelaku') is-invalid @enderror"
                                                        type="radio" name="gender_pelaku"
                                                        value="{{ $opt }}"
                                                        {{ old('gender_pelaku', $data->gender_pelaku) == $opt ? 'checked' : '' }}>
                                                    <label class="form-check-label">{{ $opt }}</label>
                                                </div>
                                            @endforeach
                                            @error('gender_pelaku')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Usia Pelaku --}}
                                    <div class="col-md-6 col-12 mb-3">
                                        <div class="form-group">
                                            <label>Usia Pelaku</label>
                                            <input type="number" name="usia_pelaku"
                                                class="form-control @error('usia_pelaku') is-invalid @enderror"
                                                value="{{ old('usia_pelaku', $data->usia_pelaku) }}"
                                                placeholder="25">
                                            @error('usia_pelaku')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Tanggal Kejadian --}}
                                    <div class="col-md-6 col-12 mb-3">
                                        <div class="form-group">
                                            <label>Tanggal Kejadian</label>
                                            <input type="date" name="tanggal_kejadian"
                                                class="form-control @error('tanggal_kejadian') is-invalid @enderror"
                                                value="{{ old('tanggal_kejadian', $data->tanggal_kejadian) }}">
                                            @error('tanggal_kejadian')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Deskripsi Kasus --}}
                                    <div class="col-md-6 col-12 mb-3">
                                        <div class="form-group">
                                            <label>Deskripsi Kasus</label>
                                            <textarea name="deskripsi_kasus" rows="3"
                                                class="form-control @error('deskripsi_kasus') is-invalid @enderror"
                                                placeholder="Deskripsi kasus...">{{ old('deskripsi_kasus', $data->deskripsi_kasus) }}</textarea>
                                            @error('deskripsi_kasus')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Tanggal Kasus Masuk (readonly dari created_at) --}}
                                    <div class="col-md-6 col-12 mb-3">
                                        <div class="form-group">
                                            <label>Tanggal Kasus Masuk</label>
                                            <input type="text" class="form-control"
                                                value="{{ \Carbon\Carbon::parse($data->created_at)->format('d/m/Y H:i') }}"
                                                readonly>
                                        </div>
                                    </div>

                                    {{-- Wilayah --}}
                                    <div class="col-md-6 col-12 mb-3">
                                        <div class="form-group">
                                            <label>Wilayah</label>
                                            <select name="kecamatan" class="form-select @error('kecamatan') is-invalid @enderror">
                                                @foreach(['Karangasem','Manggis','Rendang','Sidemen','Selat','Bebandem','Abang','Kubu'] as $opt)
                                                    <option value="{{ $opt }}" {{ old('kecamatan', $data->kecamatan) == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                                @endforeach
                                            </select>
                                            @error('kecamatan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Lokasi Kejadian --}}
                                    <div class="col-md-6 col-12 mb-3">
                                        <div class="form-group">
                                            <label>Lokasi Kejadian</label>
                                            <select name="lokasi_spesifik" class="form-select @error('lokasi_spesifik') is-invalid @enderror">
                                                @foreach(['Rumah Sendiri','Sekolah/Kampus','Tempat Kerja','Sarana Umum','Daring/Elektronik'] as $opt)
                                                    <option value="{{ $opt }}" {{ old('lokasi_spesifik', $data->lokasi_spesifik) == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                                @endforeach
                                            </select>
                                            @error('lokasi_spesifik')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- File Validasi --}}
                                    <div class="col-md-6 col-12 mb-3">
                                        <div class="form-group">
                                            <label>File Validasi (PDF/JPG/PNG)</label>
                                            @if($data->validasi)
                                                <div class="mb-1">
                                                    <small class="text-muted">File saat ini: <strong>{{ $data->validasi }}</strong></small>
                                                </div>
                                            @endif
                                            <input type="file" name="validasi" id="input-validasi"
                                                class="form-control @error('validasi') is-invalid @enderror"
                                                accept=".pdf,.jpg,.png"
                                                onchange="handleValidasiChange(this)">
                                            @error('validasi')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Disabilitas --}}
                                    <div class="col-md-6 col-12 mb-3">
                                        <div class="form-group">
                                            <label class="form-label d-block">Apakah korban memiliki disabilitas?</label>
                                            @foreach(['Ya','Tidak'] as $opt)
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input @error('disabilitas_korban') is-invalid @enderror"
                                                        type="radio" name="disabilitas_korban"
                                                        value="{{ $opt }}"
                                                        {{ old('disabilitas_korban', $data->disabilitas_korban) == $opt ? 'checked' : '' }}>
                                                    <label class="form-check-label">{{ $opt }}</label>
                                                </div>
                                            @endforeach
                                            @error('disabilitas_korban')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Status --}}
                                    <div class="col-md-6 col-12 mb-3">
                                        <div class="form-group">
                                            <label class="form-label d-block">Status</label>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('status') is-invalid @enderror"
                                                type="radio" name="status" value="0" id="status-proses"
                                                {{ old('status', $data->status ? '1' : '0') == '0' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="status-proses">Dalam Proses</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('status') is-invalid @enderror"
                                                type="radio" name="status" value="1" id="status-selesai"
                                                {{ old('status', $data->status ? '1' : '0') == '1' ? 'checked' : '' }}
                                                {{ !$data->validasi ? 'disabled' : '' }}>
                                            <label class="form-check-label {{ !$data->validasi ? 'text-muted' : '' }}" for="status-selesai">
                                                Selesai
                                            </label>
                                        </div>
                                        {{-- Info jika belum ada validasi --}}
                                            @if(!$data->validasi)
                                                <div class="mt-1">
                                                    <small class="text-warning">
                                                        <i class="bi bi-exclamation-triangle me-1"></i>
                                                        Upload file validasi terlebih dahulu untuk mengaktifkan status Selesai.
                                                    </small>
                                                </div>
                                            @endif

                                            @error('status')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end gap-2">

                                        <button type="submit" class="btn btn-primary me-1 mb-1">
                                            <i class="bi bi-save me-1"></i> Simpan
                                        </button>

                                        {{-- Tombol Hapus (soft delete) --}}
                                        <button type="button" class="btn btn-danger me-1 mb-1"
                                            onclick="konfirmasiHapus()">
                                            <i class="bi bi-trash me-1"></i> Hapus
                                        </button>

                                        <a href="/pelaporan" class="btn btn-secondary me-1 mb-1">
                                            <i class="bi bi-arrow-left me-1"></i> Kembali
                                        </a>

                                    </div>
                                </div>
                            </form>
                            {{-- Form tersembunyi untuk delete --}}
                                <form id="form-hapus"
                                    action="/detail_laporan/{{ $data->id }}/delete"
                                    method="POST" style="display:none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                        </div>
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
    function konfirmasiHapus() {
        if (confirm('Apakah Anda yakin ingin menghapus data ini?\nData tidak akan hilang permanen dan masih bisa dipulihkan.')) {
            document.getElementById('form-hapus').submit();
        }
    }

    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(el => {
            let alert = bootstrap.Alert.getOrCreateInstance(el);
            alert.close();
        });
    }, 6000);

    function handleValidasiChange(input) {
    const statusSelesai = document.getElementById('status-selesai');
    const statusProses  = document.getElementById('status-proses');
    const infoEl        = statusSelesai.closest('.form-group').querySelector('small.text-warning');

        if (input.files && input.files.length > 0) {
            // File dipilih → aktifkan status Selesai & otomatis pilih Selesai
            statusSelesai.disabled = false;
            statusSelesai.checked  = true;
            statusProses.checked   = false;
            statusSelesai.closest('label') && statusSelesai.nextElementSibling?.classList.remove('text-muted');
            if (infoEl) infoEl.style.display = 'none';
        } else {
            // File dihapus → nonaktifkan status Selesai, kembalikan ke Dalam Proses
            statusSelesai.disabled = true;
            statusSelesai.checked  = false;
            statusProses.checked   = true;
            if (infoEl) infoEl.style.display = 'block';
        }
    }

// Saat halaman load: jika sudah ada file validasi sebelumnya, aktifkan tombol selesai
    window.addEventListener('DOMContentLoaded', function() {
        const sudahAdaValidasi = {{ $data->validasi ? 'true' : 'false' }};
        const statusSelesai    = document.getElementById('status-selesai');

        if (sudahAdaValidasi) {
            statusSelesai.disabled = false;
        }
    });
</script>

@endsection