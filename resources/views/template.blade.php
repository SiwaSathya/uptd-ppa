<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin - UPTD PPA Karangasem</title>

    <link rel="shortcut icon" href="/assets/compiled/svg/favicon.svg" type="image/x-icon" />
    <link rel="stylesheet" href="/assets/compiled/css/app.css" />
    <link rel="stylesheet" href="/assets/compiled/css/app-dark.css" />
    <link rel="stylesheet" href="/assets/compiled/css/iconly.css" />
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        body { overflow-x: hidden; overflow-y: auto !important; }

        .btn-logout {
            display: flex; align-items: center; gap: 8px;
            background: none; border: none; color: #ef4444;
            font-size: 0.9rem; padding: 8px 12px; cursor: pointer;
            width: 100%; text-align: left; border-radius: 6px;
            transition: background 0.15s;
        }
        .btn-logout:hover { background: rgba(239,68,68,0.1); }
        .sidebar-footer { padding: 12px; margin-top: auto; }

        /* ══ SweetAlert Custom — seragam dengan palette #435ebe ══ */
        .swal-popup-custom {
            border-radius: 18px !important;
            padding: 32px 28px !important;
            font-family: 'Plus Jakarta Sans', 'Nunito', sans-serif !important;
            box-shadow: 0 20px 60px rgba(67,94,190,0.18) !important;
            border: 1px solid rgba(67,94,190,0.12) !important;
        }
        .swal-title-custom {
            font-size: 1.25rem !important;
            font-weight: 800 !important;
        }
        .swal-confirm-custom {
            border-radius: 10px !important;
            padding: 11px 36px !important;
            font-weight: 700 !important;
            font-size: 0.95rem !important;
            background: linear-gradient(135deg, #435ebe, #6478d4) !important;
            border: none !important;
            box-shadow: 0 4px 14px rgba(67,94,190,0.30) !important;
            transition: all 0.2s !important;
        }
        .swal-confirm-custom:hover {
            background: linear-gradient(135deg, #3450aa, #435ebe) !important;
            transform: translateY(-1px) !important;
        }
        /* Tombol cancel — abu-abu muted, nyaman di dark mode */
        .swal-cancel-custom {
            border-radius: 10px !important;
            padding: 11px 36px !important;
            font-weight: 700 !important;
            font-size: 0.95rem !important;
            background: rgba(100,116,139,0.15) !important;
            color: #94a3b8 !important;
            border: 1px solid rgba(100,116,139,0.30) !important;
            transition: all 0.2s !important;
        }
        .swal-cancel-custom:hover {
            background: rgba(100,116,139,0.25) !important;
            color: #cbd5e1 !important;
        }
        /* Jarak antar button */
        .swal2-actions {
            gap: 14px !important;
            margin-top: 24px !important;
        }
        .swal2-timer-progress-bar {
            background: linear-gradient(90deg, #435ebe, #6478d4) !important;
        }
    </style>

    @yield('css')
  </head>

  <body>
    {{--
        HAPUS @include('sweetalert::alert') dari sini.
        Notif dari Alert::success/error di controller
        ditangani manual di bawah agar style konsisten
        dan tidak bentrok dengan SweetAlert confirm logout.
    --}}
    <script src="/assets/static/js/initTheme.js"></script>

    <div id="app">
      <div id="sidebar">
        <div class="sidebar-wrapper active">
          <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">
              <div class="logo"><h4>UPTD PPA</h4></div>
              <div class="theme-toggle d-flex gap-2 align-items-center mt-2">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                     aria-hidden="true" role="img"
                     class="iconify iconify--system-uicons" width="20" height="20"
                     preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
                  <g fill="none" fill-rule="evenodd" stroke="currentColor"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2" opacity=".3"></path>
                    <g transform="translate(-210 -1)">
                      <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                      <circle cx="220.5" cy="11.5" r="4"></circle>
                      <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2"></path>
                    </g>
                  </g>
                </svg>
                <div class="form-check form-switch fs-6">
                  <input class="form-check-input me-0" type="checkbox"
                         id="toggle-dark" style="cursor:pointer"/>
                  <label class="form-check-label"></label>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                     aria-hidden="true" role="img" class="iconify iconify--mdi"
                     width="20" height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                  <path fill="currentColor" d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z"/>
                </svg>
              </div>
              <div class="sidebar-toggler x">
                <a href="#" class="sidebar-hide d-xl-none d-block">
                  <i class="bi bi-x bi-middle"></i>
                </a>
              </div>
            </div>
          </div>

          <div class="sidebar-menu">
            <ul class="menu">
              <li class="sidebar-title">Menu</li>

              <li class="sidebar-item">
                  <a href="/publik" target="_blank" class='sidebar-link'>
                      <i class="bi bi-globe"></i>
                      <span>Lihat Halaman Publik</span>
                  </a>
              </li>

              <li class="sidebar-item {{ request()->is('dashboard') ? 'active' : '' }}">
                <a href="/dashboard" class="sidebar-link">
                  <i class="bi bi-grid-fill"></i><span>Dashboard</span>
                </a>
              </li>

              <li class="sidebar-item {{ request()->is('pelaporan') || request()->is('detail_laporan/*') || request()->is('detail_rujukan/*') || request()->is('kirim_pesan/*') ? 'active' : '' }}">
                <a href="/pelaporan" class="sidebar-link">
                  <i class="bi bi-file-earmark-text-fill"></i><span>Pelaporan</span>
                </a>
              </li>

              <li class="sidebar-item {{ request()->is('cetak_laporan') ? 'active' : '' }}">
                <a href="/cetak_laporan" class="sidebar-link">
                  <i class="bi bi-printer-fill"></i><span>Cetak Laporan</span>
                </a>
              </li>

              <li class="sidebar-item {{ request()->is('seting') ? 'active' : '' }}">
                <a href="/seting" class="sidebar-link">
                  <i class="bi bi-gear-fill"></i><span>Pengaturan</span>
                </a>
              </li>

              <div class="sidebar-footer">
                {{-- Form logout — submit dipanggil dari JS setelah konfirmasi SweetAlert --}}
                <form id="form-logout" action="/logout" method="POST">
                  @csrf
                </form>
                <button type="button" class="btn btn-danger w-100" id="btn-logout-trigger">
                  <i class="bi bi-box-arrow-right"></i>
                  <span>Keluar</span>
                </button>
              </div>
            </ul>
          </div>

        </div>
      </div>

      <div id="main">
        <header class="mb-3">
          <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
          </a>
        </header>
        <main>@yield('main')</main>
        <footer>
          <div class="footer clearfix mb-0 text-muted"></div>
        </footer>
      </div>
    </div>

    <script src="/assets/static/js/components/dark.js"></script>
    <script src="/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="/assets/compiled/js/app.js"></script>

    {{-- SweetAlert2 — load sekali di template induk --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
      /* ── Konfigurasi style Swal yang dipakai ulang ── */
      const SWAL_STYLE = {
          customClass: {
              popup:         'swal-popup-custom',
              title:         'swal-title-custom',
              confirmButton: 'swal-confirm-custom',
              cancelButton:  'swal-cancel-custom',
          },
          showClass: { popup: 'animate__animated animate__fadeInDown animate__faster' },
          hideClass: { popup: 'animate__animated animate__fadeOutUp animate__faster' },
          buttonsStyling: false,   // ← wajib false agar customClass button aktif
      };

      document.addEventListener('DOMContentLoaded', function () {

          /* ── 1. Konfirmasi Logout ── */
          const btnLogout = document.getElementById('btn-logout-trigger');
          if (btnLogout) {
              btnLogout.addEventListener('click', function () {
                  Swal.fire({
                      ...SWAL_STYLE,
                      title:              'Konfirmasi Logout',
                      text:               'Apakah Anda yakin ingin keluar?',
                      icon:               'question',
                      showCancelButton:   true,
                      confirmButtonText:  'Ya, Keluar',
                      cancelButtonText:   'Batal',
                      reverseButtons:     true,
                  }).then(function (result) {
                      if (result.isConfirmed) {
                          document.getElementById('form-logout').submit();
                      }
                  });
              });
          }

          /* ── 2. Notif dari Alert::success / Alert::error controller ── */
          @if(Session::has('alert.config'))
          @php
              $cfg = Session::get('alert.config');
              if (is_string($cfg)) $cfg = json_decode($cfg, true);
          @endphp
          Swal.fire({
              ...SWAL_STYLE,
              title:            @json($cfg['title'] ?? ''),
              text:             @json($cfg['text']  ?? ''),
              icon:             @json($cfg['icon']  ?? 'info'),
              confirmButtonText: 'OK',
              timer:            2800,
              timerProgressBar: true,
          });
          @endif

      });

      /* ── Burger button ── */
      document.addEventListener('DOMContentLoaded', function () {
          var burgerBtn = document.querySelector('.burger-btn');
          if (burgerBtn) {
              burgerBtn.addEventListener('click', function (e) {
                  e.preventDefault();
              });
          }
      });
    </script>

    @yield('js')
  </body>
</html>