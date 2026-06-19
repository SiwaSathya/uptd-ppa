@extends('template')

@section('css')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Laporan - UPTD PPA Karangasem</title>

    <link rel="shortcut icon" href="/assets/compiled/svg/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="/assets/compiled/css/app.css">
    <link rel="stylesheet" href="/assets/compiled/css/app-dark.css">
@endsection

@section('main')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Tambah Data Laporan</h3>
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
                            <form action="/create_data/store" method="POST">
                                @csrf
                                <div class="row">

                                     {{-- Pelapor --}}
                                     <div class="col-md-6 col-12 mb-3">
                                         <div class="form-group">
                                             <label>Pelapor <span class="text-danger">*</span></label>
                                             <select name="pelapor" id="select-pelapor"
                                                 class="form-select @error('pelapor') is-invalid @enderror"
                                                 onchange="toggleInstansi(this.value)"
                                                 required>
                                                 <option value="">-- Pilih Pelapor --</option>
                                                 @foreach(['Korban','Keluarga','Kerabat','Instansi'] as $opt)
                                                     <option value="{{ $opt }}" {{ old('pelapor') == $opt ? 'selected' : '' }}>{{ $opt }}</option>
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
                                            <label>Nomor Pelapor <span class="text-muted small">(opsional)</span></label>
                                            <input type="text" name="user_number"
                                                class="form-control @error('user_number') is-invalid @enderror"
                                                value="{{ old('user_number') }}"
                                                placeholder="08123456789">
                                            {{-- hapus required --}}
                                            @error('user_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                     </div>

                                     {{-- Tanggal Kasus Masuk --}}
                                     <div class="col-md-6 col-12 mb-3">
                                         <div class="form-group">
                                             <label>Tanggal Kasus Masuk <span class="text-danger">*</span></label>
                                             <input type="datetime-local" name="tanggal_kasus_masuk"
                                                 class="form-control @error('tanggal_kasus_masuk') is-invalid @enderror"
                                                 value="{{ old('tanggal_kasus_masuk', now()->format('Y-m-d\TH:i')) }}"
                                                 required>
                                             @error('tanggal_kasus_masuk')
                                                 <div class="invalid-feedback">{{ $message }}</div>
                                             @enderror
                                         </div>
                                     </div>

                                     {{-- Nama Instansi (muncul jika pelapor = Instansi) --}}
                                     <div class="col-md-6 col-12 mb-3" id="field-instance"
                                         style="display: {{ old('pelapor') == 'Instansi' ? 'block' : 'none' }};">
                                         <div class="form-group">
                                             <label>Nama Instansi <span class="text-danger">*</span></label>
                                             <input type="text" name="instance"
                                                 class="form-control @error('instance') is-invalid @enderror"
                                                 value="{{ old('instance') }}"
                                                 placeholder="Nama instansi"
                                                 required
                                                 aria-required="true">
                                             @error('instance')
                                                 <div class="invalid-feedback">{{ $message }}</div>
                                             @enderror
                                         </div>
                                     </div>

                                    {{-- Alamat Instansi (opsional) --}}
                                    <div class="col-md-6 col-12 mb-3" id="field-address-instance"
                                        style="display: {{ old('pelapor') == 'Instansi' ? 'block' : 'none' }};">
                                        <div class="form-group">
                                            <label>Alamat Instansi <span class="text-muted small">(opsional)</span></label>
                                            <input type="text" name="address_instance"
                                                class="form-control @error('address_instance') is-invalid @enderror"
                                                value="{{ old('address_instance') }}"
                                                placeholder="Alamat instansi">
                                            @error('address_instance')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                     {{-- Nama Korban --}}
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label>Nama Korban <span class="text-muted small">(opsional)</span></label>
                                                <input type="text" name="nama_korban"
                                                    class="form-control @error('nama_korban') is-invalid @enderror"
                                                    value="{{ old('nama_korban') }}"
                                                    placeholder="Nama korban">
                                                {{-- hapus required --}}
                                                @error('nama_korban')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                     {{-- Jenis Kelamin Korban --}}
                                     <div class="col-md-6 col-12 mb-3">
                                         <div class="form-group">
                                             <label class="form-label d-block">Jenis Kelamin Korban <span class="text-danger">*</span></label>
                                             @foreach(['Laki-laki','Perempuan'] as $opt)
                                                 <div class="form-check form-check-inline">
                                                     <input class="form-check-input @error('gender_korban') is-invalid @enderror"
                                                         type="radio" name="gender_korban"
                                                         value="{{ $opt }}"
                                                         {{ old('gender_korban') == $opt ? 'checked' : '' }}
                                                         required
                                                         aria-required="true">
                                                     <label class="form-check-label">{{ $opt }}</label>
                                                 </div>
                                             @endforeach
                                             @error('gender_korban')
                                                 <div class="text-danger small">{{ $message }}</div>
                                             @enderror
                                         </div>
                                     </div>

                                     {{-- Usia Korban --}}
                                     <div class="col-md-6 col-12 mb-3">
                                         <div class="form-group">
                                             <label>Usia Korban <span class="text-danger">*</span></label>
                                             <input type="number" name="usia_korban"
                                                 class="form-control @error('usia_korban') is-invalid @enderror"
                                                 value="{{ old('usia_korban') }}"
                                                 placeholder="20" min="1"
                                                 required
                                                 aria-required="true">
                                             @error('usia_korban')
                                                 <div class="invalid-feedback">{{ $message }}</div>
                                             @enderror
                                         </div>
                                     </div>

                                     {{-- Jenis Kasus --}}
                                     <div class="col-md-6 col-12 mb-3">
                                         <div class="form-group">
                                             <label>Jenis Kasus <span class="text-danger">*</span></label>
                                             <select name="jenis_kasus"
                                                 class="form-select @error('jenis_kasus') is-invalid @enderror"
                                                 required
                                                 aria-required="true">
                                                 <option value="">-- Pilih Jenis Kasus --</option>
                                                 @foreach(['KDRT Fisik','KDRT Psikis','Persetubuhan','Pelecehan','Pemerkosaan','Penelantaran','Penganiayaan','Pencurian','Bullying','TPPO (Trafficking)','Pedofilia','Ekspolitasi seksual','Ekspolitasi ekonomi','Korban kejahatan ITE','Trauma Lakalantas'] as $opt)
                                                     <option value="{{ $opt }}" {{ old('jenis_kasus') == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                                 @endforeach
                                             </select>
                                             @error('jenis_kasus')
                                                 <div class="invalid-feedback">{{ $message }}</div>
                                             @enderror
                                         </div>
                                     </div>

                                     {{-- Tanggal Kejadian --}}
                                     <div class="col-md-6 col-12 mb-3">
                                         <div class="form-group">
                                             <label>Tanggal Kejadian <span class="text-danger">*</span></label>
                                             <input type="date" name="tanggal_kejadian"
                                                 class="form-control @error('tanggal_kejadian') is-invalid @enderror"
                                                 value="{{ old('tanggal_kejadian') }}"
                                                 required
                                                 aria-required="true">
                                             @error('tanggal_kejadian')
                                                 <div class="invalid-feedback">{{ $message }}</div>
                                             @enderror
                                         </div>
                                     </div>

                                    {{-- Nama Pelaku --}}
                                    <div class="col-md-6 col-12 mb-3">
                                        <div class="form-group">
                                            <label>Nama Pelaku <span class="text-muted small">(opsional)</span></label>
                                            <input type="text" name="nama_pelaku"
                                                class="form-control"
                                                value="{{ old('nama_pelaku') }}"
                                                placeholder="Nama pelaku">
                                        </div>
                                    </div>

                                    {{-- Jenis Kelamin Pelaku --}}
                                    <div class="col-md-6 col-12 mb-3">
                                        <div class="form-group">
                                            <label class="form-label d-block">Jenis Kelamin Pelaku <span class="text-muted small">(opsional)</span></label>
                                            @foreach(['Laki-laki','Perempuan'] as $opt)
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input"
                                                        type="radio" name="gender_pelaku"
                                                        value="{{ $opt }}"
                                                        {{ old('gender_pelaku') == $opt ? 'checked' : '' }}>
                                                    <label class="form-check-label">{{ $opt }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    {{-- Usia Pelaku --}}
                                    <div class="col-md-6 col-12 mb-3">
                                        <div class="form-group">
                                            <label>Usia Pelaku <span class="text-muted small">(opsional)</span></label>
                                            <input type="number" name="usia_pelaku"
                                                class="form-control"
                                                value="{{ old('usia_pelaku') }}"
                                                placeholder="25" min="1">
                                        </div>
                                    </div>

                                    {{-- Hubungan Pelaku --}}
                                    <div class="col-md-6 col-12 mb-3">
                                        <div class="form-group">
                                            <label>Hubungan Pelaku dengan Korban <span class="text-muted small">(opsional)</span></label>
                                            <select name="hubungan_pelaku" class="form-select">
                                                <option value="">-- Pilih --</option>
                                                @foreach(['Keluarga','Kerabat','Orang Tidak Dikenal'] as $opt)
                                                    <option value="{{ $opt }}" {{ old('hubungan_pelaku') == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                     {{-- Wilayah --}}
                                     <div class="col-md-6 col-12 mb-3">
                                         <div class="form-group">
                                             <label>Wilayah <span class="text-danger">*</span></label>
                                             <select name="kecamatan"
                                                 class="form-select @error('kecamatan') is-invalid @enderror"
                                                 required
                                                 aria-required="true">
                                                 <option value="">-- Pilih Wilayah --</option>
                                                 @foreach(['Karangasem','Manggis','Rendang','Sidemen','Selat','Bebandem','Abang','Kubu'] as $opt)
                                                     <option value="{{ $opt }}" {{ old('kecamatan') == $opt ? 'selected' : '' }}>{{ $opt }}</option>
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
                                            <label>Lokasi Kejadian <span class="text-danger">*</span></label>
                                            <select name="lokasi_spesifik"
                                                class="form-select @error('lokasi_spesifik') is-invalid @enderror">
                                                <option value="">-- Pilih Lokasi --</option>
                                                @foreach(['Rumah Sendiri','Sekolah/Kampus','Tempat Kerja','Sarana Umum','Daring/Elektronik'] as $opt)
                                                    <option value="{{ $opt }}" {{ old('lokasi_spesifik') == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                                @endforeach
                                            </select>
                                            @error('lokasi_spesifik')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Deskripsi Kasus --}}
                                    <div class="col-md-6 col-12 mb-3">
                                        <div class="form-group">
                                            <label>Deskripsi Kasus <span class="text-muted small">(opsional)</span></label>
                                            <textarea name="deskripsi_kasus" rows="4"
                                                class="form-control"
                                                placeholder="Deskripsi kasus...">{{ old('deskripsi_kasus') }}</textarea>
                                        </div>
                                    </div>

                                    {{-- Disabilitas --}}
                                    <div class="col-md-6 col-12 mb-3">
                                        <div class="form-group">
                                            <label class="form-label d-block">Apakah korban memiliki disabilitas? <span class="text-danger">*</span></label>
                                            @foreach(['Ya','Tidak'] as $opt)
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input @error('disabilitas_korban') is-invalid @enderror"
                                                        type="radio" name="disabilitas_korban"
                                                        value="{{ $opt }}"
                                                        {{ old('disabilitas_korban') == $opt ? 'checked' : '' }}>
                                                    <label class="form-check-label">{{ $opt }}</label>
                                                </div>
                                            @endforeach
                                            @error('disabilitas_korban')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end gap-2">
                                        <a href="/pelaporan" class="btn btn-secondary me-1 mb-1">
                                            <i class="bi bi-arrow-left me-1"></i> Kembali
                                        </a>
                                        <button type="submit" class="btn btn-primary me-1 mb-1">
                                            <i class="bi bi-save me-1"></i> Simpan
                                        </button>
                                    </div>
                                </div>

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
    function toggleInstansi(value) {
        const fieldInstance        = document.getElementById('field-instance');
        const fieldAddressInstance = document.getElementById('field-address-instance');
        const inputInstance        = fieldInstance.querySelector('input');

        if (value === 'Instansi') {
            fieldInstance.style.display        = 'block';
            fieldAddressInstance.style.display = 'block';
            inputInstance.required             = true;
        } else {
            fieldInstance.style.display        = 'none';
            fieldAddressInstance.style.display = 'none';
            inputInstance.required             = false;
            inputInstance.value                = '';
        }
    }

    // Set required jika sudah ada old value Instansi (setelah validasi gagal)
    window.addEventListener('DOMContentLoaded', function() {
        var pelapor = document.getElementById('select-pelapor').value;
        if (pelapor === 'Instansi') {
            document.getElementById('field-instance').querySelector('input').required = true;
        }
    });

    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(el => {
            let alert = bootstrap.Alert.getOrCreateInstance(el);
            alert.close();
        });
    }, 4000);
</script>
@endsection