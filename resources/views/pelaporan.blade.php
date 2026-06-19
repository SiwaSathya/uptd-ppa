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
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
      <h3>Data Pelaporan</h3>
      <p class="text-muted mb-0">Kelola dan pantau semua laporan kasus yang masuk</p>
    </div>
  </div>
</div>
<div class="page-content mt-3">
  <div class="row">
    <div class="col-12 col-lg-12">
      <div class="card">
        <div class="card-body">
          @if($data->isEmpty())
          <div class="card">
            <div class="card-body text-center py-5">
              <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
              <p class="text-muted mt-2 mb-0">Belum ada data pelaporan.</p>
            </div>
          </div>
          @else
          <div class="d-flex align-items-center gap-2 mb-3">
            
            <strong>{{ count($data) }}</strong> Total data laporan
          </div>

          {{-- Filter Tahun --}}
          <div class="d-flex align-items-center gap-2 mb-3 flex-wrap">
            <label class="fw-semibold mb-0 me-1">
              <i class="bi bi-funnel me-1"></i>Filter Tahun:
            </label>
            <button class="btn btn-sm btn-primary rounded-pill filter-tahun-btn active"
                    data-tahun="{{ date('Y') }}">
              {{ date('Y') }}
            </button>
            @php
              // Ambil tahun unik dari data
              $tahunList = $data->map(fn($d) => \Carbon\Carbon::parse($d->created_at)->year)
                               ->unique()->sortDesc()->values();
            @endphp
            @foreach($tahunList as $thn)
              @if($thn != date('Y'))
                <button class="btn btn-sm btn-outline-primary rounded-pill filter-tahun-btn"
                        data-tahun="{{ $thn }}">
                  {{ $thn }}
                </button>
              @endif
            @endforeach
            <button class="btn btn-sm btn-outline-secondary rounded-pill filter-tahun-btn"
                    data-tahun="semua">
              Semua
            </button>
          </div>

          <div class="table-responsive">
            <table class="table table-hover" id="table1">
              <thead>
                  <tr>
                      <th>ID Kasus</th>
                      <th>Nama Korban</th>
                      <th>Jenis Kelamin</th>
                      <th>Waktu Masuk</th>
                      <th>Jenis Kasus</th>
                      <th>Usia</th>
                      <th>Wilayah</th>
                      <th>Pelapor</th>
                      <th>Status</th>
                      <th>Action</th>
                  </tr>
              </thead>
              <tbody>
                @foreach ($data as $item)
                  <tr>
                      <td>{{ $item->id_kasus_formatted }}</td>
                      <td>{{ $item->nama_korban }}</td>
                      <td>{{ $item->gender_korban }}</td>
                      <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i') }}</td>
                      <td>{{ $item->jenis_kasus }}</td>
                      <td>{{ $item->usia_korban }}</td>
                      <td>{{ $item->kecamatan }}</td>
                      <td>
                          @if(strtolower($item->pelapor) === 'instansi')
                              <a href="/detail_rujukan/{{ $item->id }}" class="badge bg-danger text-white" style="opacity:0.85;">Rujukan</a>
                          @else
                              <a href="/detail_laporan/{{ $item->id }}" class="badge bg-warning text-white rounded-pill">Baru</a>
                          @endif
                      </td>
                      <td>
                          @if($item->status)
                              <span class="badge bg-success rounded-pill px-3 py-1">
                                  <i class="bi bi-check-circle me-1"></i>Selesai
                              </span>
                          @else
                              <span class="badge bg-warning text-dark rounded-pill px-3 py-1">
                                  <i class="bi bi-hourglass-split me-1"></i>Dalam Proses
                              </span>
                          @endif
                      </td>
                      <td class="d-flex gap-2 align-items-center">
                          <div class="d-flex flex-column align-items-center">
                              <a href="/kirim_pesan/{{ $item->id }}" title="Kirim Jadwal WhatsApp">
                                  <i class="bi bi-whatsapp fs-5 text-success"></i>
                              </a>
                              @if($item->status_kirim)
                                  <span class="badge bg-success" style="font-size:0.6rem;margin-top:2px;">Terkirim</span>
                              @else
                                  <span class="badge bg-light text-muted" style="font-size:0.6rem;margin-top:2px;">Belum</span>
                              @endif
                          </div>
                      </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          @endif

          <div class="mt-3">
            <a href="create_data" class="btn btn-primary">
              <i class="bi bi-plus-lg me-1"></i> Tambah Data
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')

<script src="/assets/extensions/jquery/jquery.min.js"></script>
<script src="/assets/extensions/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="/assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function () {
    const tahunSekarang = new Date().getFullYear().toString();

    // Custom filter berdasarkan tahun di kolom Waktu Masuk (index 3)
    $.fn.dataTable.ext.search.push(function (settings, data) {
        // data[3] = isi kolom Waktu Masuk, format: "dd-mm-yyyy HH:ii"
        const nilaiFilter = $('#filter-tahun-aktif').val();
        if (!nilaiFilter || nilaiFilter === 'semua') return true;

        const waktuMasuk = data[3] || '';
        // Ambil tahun dari format dd-mm-yyyy → split '-') → [dd, mm, yyyy]
        const parts = waktuMasuk.split('-');
        const tahunData = parts.length >= 3 ? parts[2].substring(0, 4) : '';

        return tahunData === nilaiFilter;
    });

    // Input hidden untuk menyimpan tahun aktif
    $('body').append('<input type="hidden" id="filter-tahun-aktif" value="' + tahunSekarang + '">');

    const table = $('#table1').DataTable({
        order: [[3, 'desc']],
        columnDefs: [
            { orderable: false, targets: [9] } // kolom Action tidak bisa disort
        ],
        language: {
            search:       'Cari:',
            lengthMenu:   'Tampilkan _MENU_ data',
            info:         'Menampilkan _START_ - _END_ dari _TOTAL_ data',
            infoEmpty:    'Tidak ada data',
            zeroRecords:  'Data tidak ditemukan',
            paginate: {
                first:    'Pertama',
                last:     'Terakhir',
                next:     'Berikutnya',
                previous: 'Sebelumnya'
            }
        }
    });

    // Trigger draw awal agar filter tahun sekarang langsung aktif
    table.draw();

    // Klik tombol filter tahun
    $(document).on('click', '.filter-tahun-btn', function () {
        const tahun = $(this).data('tahun').toString();

        // Update tombol aktif
        $('.filter-tahun-btn').removeClass('active btn-primary btn-outline-secondary btn-outline-primary')
                              .addClass('btn-outline-primary');
        $(this).removeClass('btn-outline-primary btn-outline-secondary')
               .addClass('btn-primary active');

        // Tombol "Semua" pakai warna berbeda
        if (tahun === 'semua') {
            $('.filter-tahun-btn[data-tahun="semua"]')
                .removeClass('btn-outline-secondary btn-outline-primary btn-primary')
                .addClass('btn-secondary active');
        }

        // Set nilai filter dan redraw tabel
        $('#filter-tahun-aktif').val(tahun === 'semua' ? '' : tahun);
        table.draw();
    });
});
</script>
@endsection