<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - UPTD PPA Karangasem Admin</title>

    <link rel="shortcut icon" href="/assets/compiled/svg/favicon.svg" type="image/x-icon" />
    <link rel="stylesheet" href="/assets/compiled/css/app.css" />
    <link rel="stylesheet" href="/assets/compiled/css/app-dark.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{--
        HAPUS @include('sweetalert::alert') dari sini.
        Kita handle semua notif (login error + logout success)
        secara manual dengan SweetAlert2 di bawah supaya
        tidak ada konflik dengan package bawaan.
    --}}

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        /* ══════════════════════════════════════
           CSS VARIABLES
        ══════════════════════════════════════ */
        :root {
            --accent:       #435ebe;
            --accent-dark:  #3450aa;
            --accent-light: #6478d4;
            --accent-glow:  rgba(67,94,190,0.28);
            --bg-panel:     #f7f8ff;
            --bg-page:      #e8ecf8;
            --text-primary: #2c3470;
            --text-sub:     #5560a0;
            --text-muted:   #8e96c8;
            --border:       #cfd6f0;
            --input-bg:     #eef1ff;
            --input-focus:  #e4e9ff;
        }
        [data-theme="dark"] {
            --bg-panel:     #1e2433;
            --bg-page:      #141928;
            --text-primary: #eaecf5;
            --text-sub:     #9ca3b8;
            --text-muted:   #5a6278;
            --border:       #2e3650;
            --input-bg:     #252d3d;
            --input-focus:  #2c3550;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html, body {
            height: 100%;
            font-size: 18px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-page);
            overflow: hidden;
            transition: background 0.3s;
        }

        /* ══ LAYOUT ══ */
        .auth-wrapper { display: flex; height: 100vh; width: 100vw; }

        /* ══ LEFT PANEL ══ */
        .auth-left {
            flex: 0 0 56%;
            background: linear-gradient(140deg, #152b7e 0%, #2646c0 35%, #435ebe 65%, #6478d4 100%);
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 72px 88px;
            overflow: hidden;
        }
        .auth-left .ring {
            position: absolute; border-radius: 50%;
            border: 1.5px solid rgba(255,255,255,0.12); pointer-events: none;
        }
        .auth-left .ring-1 { width:420px; height:420px; bottom:-120px; left:-100px; }
        .auth-left .ring-2 { width:620px; height:620px; bottom:-210px; left:-190px; border-color:rgba(255,255,255,0.06); }
        .auth-left .ring-3 { width:290px; height:290px; bottom:-55px;  left:-45px;  border-color:rgba(255,255,255,0.18); }
        .auth-left .blob {
            position: absolute; top:-120px; right:-90px;
            width:460px; height:460px;
            background: radial-gradient(circle, rgba(100,120,220,0.5) 0%, transparent 68%);
            border-radius:50%; filter:blur(52px); pointer-events:none;
        }
        .auth-left-content { position: relative; z-index: 2; }
        .auth-brand-name {
            display: block; font-size: 1rem; font-weight: 700;
            color: rgba(255,255,255,0.5); letter-spacing: 0.04em;
            text-transform: uppercase; margin-bottom: 48px;
        }
        .auth-headline {
            font-size: 3.2rem; font-weight: 800; color: #fff;
            line-height: 1.12; letter-spacing: -0.025em; margin-bottom: 22px;
        }
        .auth-headline .dim { color: rgba(255,255,255,0.5); }
        .auth-sub {
            font-size: 1.05rem; color: rgba(255,255,255,0.68);
            line-height: 1.7; max-width: 420px; margin-bottom: 52px;
        }
        .auth-chips { display: flex; gap: 12px; flex-wrap: wrap; }
        .auth-chip {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(255,255,255,0.13); border: 1px solid rgba(255,255,255,0.22);
            border-radius: 50px; padding: 10px 22px;
            font-size: 0.85rem; font-weight: 600;
            color: rgba(255,255,255,0.92); backdrop-filter: blur(8px); line-height: 1;
        }
        .auth-chip i { font-size: 15px; display: flex; align-items: center; line-height: 1; }

        /* ══ RIGHT PANEL ══ */
        .auth-right {
            flex: 0 0 44%;
            background: var(--bg-panel);
            display: flex; flex-direction: column;
            justify-content: center; align-items: center;
            padding: 56px 72px; position: relative;
            transition: background 0.3s;
        }
        .theme-toggle {
            position: absolute; top: 28px; right: 28px;
            width: 48px; height: 48px; border-radius: 50%;
            border: 1.5px solid var(--border);
            background: var(--input-bg); color: var(--text-sub);
            cursor: pointer; display: flex; align-items: center;
            justify-content: center; line-height: 0; font-size: 0; padding: 0;
            transition: background 0.2s, border-color 0.2s, color 0.2s;
        }
        .theme-toggle:hover { background: var(--accent); border-color: var(--accent); color: #fff; }
        .theme-toggle .bi { font-size: 20px; line-height: 1; display: flex; align-items: center; justify-content: center; }
        .theme-toggle .icon-sun  { display: none; }
        .theme-toggle .icon-moon { display: flex; }
        [data-theme="dark"] .theme-toggle .icon-sun  { display: flex; }
        [data-theme="dark"] .theme-toggle .icon-moon { display: none; }

        .auth-form-wrap { width: 100%; max-width: 420px; }
        .auth-greeting { margin-bottom: 40px; }
        .auth-greeting h2 {
            font-size: 2.2rem; font-weight: 800; color: var(--text-primary);
            letter-spacing: -0.025em; margin-bottom: 10px; transition: color 0.3s;
        }
        .auth-greeting p { font-size: 1.05rem; color: var(--text-sub); transition: color 0.3s; }

        .auth-alert {
            background: rgba(220,53,69,0.08); border: 1px solid rgba(220,53,69,0.22);
            border-radius: 12px; padding: 14px 18px; font-size: 0.95rem;
            color: #dc3545; margin-bottom: 22px;
            display: flex; align-items: center; gap: 10px; line-height: 1.4;
        }
        .auth-alert .bi { font-size: 20px; flex-shrink: 0; display: flex; align-items: center; line-height: 1; }

        .field-group { margin-bottom: 22px; }
        .field-label {
            display: block; font-size: 0.82rem; font-weight: 700;
            color: var(--text-sub); letter-spacing: 0.07em;
            text-transform: uppercase; margin-bottom: 9px; transition: color 0.3s;
        }
        .field-wrap { position: relative; }
        .field-input {
            width: 100%; background: var(--input-bg);
            border: 1.5px solid var(--border); border-radius: 14px;
            padding: 17px 20px 17px 54px; font-size: 1.05rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text-primary); outline: none;
            transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
        }
        .field-input::placeholder { color: var(--text-muted); }
        .field-input:focus {
            border-color: var(--accent); background: var(--input-focus);
            box-shadow: 0 0 0 4px var(--accent-glow);
        }
        .field-icon {
            position: absolute; left: 18px; top: 0; bottom: 0;
            display: flex; align-items: center; justify-content: center;
            pointer-events: none; color: var(--text-muted);
            transition: color 0.2s; line-height: 0;
        }
        .field-icon .bi { font-size: 19px; line-height: 1; display: flex; align-items: center; }
        .field-wrap:focus-within .field-icon { color: var(--accent); }

        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, var(--accent) 0%, var(--accent-light) 100%);
            color: #fff; border: none; border-radius: 14px;
            padding: 18px 24px; font-size: 1.1rem; font-weight: 700;
            font-family: 'Plus Jakarta Sans', sans-serif;
            cursor: pointer; margin-top: 12px; transition: all 0.25s;
            box-shadow: 0 5px 18px var(--accent-glow); letter-spacing: 0.01em;
            display: flex; align-items: center; justify-content: center; gap: 10px; line-height: 1;
        }
        .btn-login .bi { font-size: 20px; line-height: 1; display: flex; align-items: center; }
        .btn-login:hover {
            background: linear-gradient(135deg, var(--accent-dark) 0%, var(--accent) 100%);
            box-shadow: 0 8px 24px var(--accent-glow); transform: translateY(-2px);
        }
        .btn-login:active { transform: translateY(0); }

        .auth-footer {
            margin-top: 36px; text-align: center;
            font-size: 0.85rem; color: var(--text-muted); transition: color 0.3s;
        }
        .auth-footer strong { color: var(--text-sub); }

        /* ══ SWEETALERT CUSTOM ══ */
        .swal-popup-custom {
            border-radius: 18px !important;
            padding: 32px 28px !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            box-shadow: 0 20px 60px rgba(67,94,190,0.18) !important;
            border: 1px solid rgba(67,94,190,0.12) !important;
        }
        .swal-title-custom {
            font-size: 1.3rem !important;
            font-weight: 800 !important;
            color: #1a2035 !important;
        }
        .swal-btn-custom {
            border-radius: 10px !important;
            padding: 10px 32px !important;
            font-weight: 700 !important;
            font-size: 0.95rem !important;
            background: linear-gradient(135deg, #435ebe, #6478d4) !important;
            border: none !important;
            box-shadow: 0 4px 14px rgba(67,94,190,0.30) !important;
            transition: all 0.2s !important;
        }
        .swal-btn-custom:hover {
            background: linear-gradient(135deg, #3450aa, #435ebe) !important;
            transform: translateY(-1px) !important;
        }
        .swal2-timer-progress-bar {
            background: linear-gradient(90deg, #435ebe, #6478d4) !important;
        }

        @media (max-width: 960px) {
            html, body { font-size: 17px; overflow: auto; }
            .auth-left  { display: none; }
            .auth-right { flex: 0 0 100%; padding: 48px 32px; }
            .auth-wrapper { height: auto; min-height: 100vh; }
        }
    </style>
</head>

<body>
    <script src="/assets/static/js/initTheme.js"></script>

    <div class="auth-wrapper">

        {{-- ══ LEFT ══ --}}
        <div class="auth-left">
            <div class="blob"></div>
            <div class="ring ring-1"></div>
            <div class="ring ring-2"></div>
            <div class="ring ring-3"></div>
            <div class="auth-left-content">
                <h1 class="auth-brand-name">UPTD PPA Karangasem</h1>
                <h2 class="auth-headline">
                    Sistem Informasi<br>
                    <span class="dim">Perlindungan</span><br>
                    Perempuan &amp; Anak
                </h2>
                <p class="auth-sub">
                    Platform pengelolaan data kasus dan pelaporan terpadu untuk UPTD PPA Kabupaten Karangasem.
                </p>
                <div class="auth-chips">
                    <div class="auth-chip"><i class="bi bi-clock-fill"></i> Layanan 24 Jam</div>
                    <div class="auth-chip"><i class="bi bi-shield-lock-fill"></i> Data Aman &amp; Rahasia</div>
                    <div class="auth-chip"><i class="bi bi-geo-alt-fill"></i> Karangasem</div>
                </div>
            </div>
        </div>

        {{-- ══ RIGHT ══ --}}
        <div class="auth-right">
            <button class="theme-toggle" onclick="toggleTheme()" title="Ganti tema">
                <i class="bi bi-sun-fill icon-sun"></i>
                <i class="bi bi-moon-fill icon-moon"></i>
            </button>

            <div class="auth-form-wrap">
                <div class="auth-greeting">
                    <h2>Selamat Datang!</h2>
                    <p>Masuk menggunakan akun admin Anda</p>
                </div>

                @if(session('loginError'))
                    <div class="auth-alert">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        {{ session('loginError') }}
                    </div>
                @endif
                @if($errors->any())
                    <div class="auth-alert">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        Email atau password tidak valid.
                    </div>
                @endif

                <form action="/login/post" method="POST" autocomplete="off">
                    @csrf
                    <div class="field-group">
                        <label class="field-label" for="email">Alamat Email</label>
                        <div class="field-wrap">
                            <input id="email" name="email" type="email" required
                                class="field-input" placeholder="nama@domain.com"
                                value="{{ old('email') }}" autofocus />
                            <span class="field-icon"><i class="bi bi-envelope-fill"></i></span>
                        </div>
                    </div>
                    <div class="field-group">
                        <label class="field-label" for="password">Password</label>
                        <div class="field-wrap">
                            <input id="password" name="password" type="password" required
                                class="field-input" placeholder="Masukkan password" />
                            <span class="field-icon"><i class="bi bi-shield-lock-fill"></i></span>
                        </div>
                    </div>
                    <button type="submit" class="btn-login">
                        <i class="bi bi-box-arrow-in-right"></i> Masuk
                    </button>
                </form>

                <div class="auth-footer">
                    <strong>Admin Panel</strong> &bull; UPTD PPA Karangasem
                </div>
            </div>
        </div>

    </div>

    {{-- ══ SWEETALERT2 — load sekali saja ══ --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        /* ── Theme toggle ── */
        (function () {
            const saved = localStorage.getItem('uptd-theme') || 'light';
            document.documentElement.setAttribute('data-theme', saved);
        })();
        function toggleTheme() {
            const html = document.documentElement;
            const next = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', next);
            localStorage.setItem('uptd-theme', next);
        }

        /* ── Konfigurasi tampilan Swal yang dipakai ulang ── */
        const swalConfig = {
            customClass: {
                popup:         'swal-popup-custom',
                title:         'swal-title-custom',
                confirmButton: 'swal-btn-custom',
            },
            showClass: { popup: 'animate__animated animate__fadeInDown animate__faster' },
            hideClass: { popup: 'animate__animated animate__fadeOutUp animate__faster' },
            confirmButtonText:  'OK',
            timer:            2800,
            timerProgressBar: true,
        };

        window.addEventListener('DOMContentLoaded', function () {

            @if(session('logout_success'))
            /* ── Notif logout berhasil ── */
            Swal.fire({
                ...swalConfig,
                title: 'Logout',
                text:  'Berhasil keluar.',
                icon:  'success',
            });
            @endif

            @if(Session::has('alert.config'))
            /* ── Notif dari RealRashid Alert (login success/error) ── */
            @php
                $cfg = Session::get('alert.config');
                if (is_string($cfg)) $cfg = json_decode($cfg, true);
            @endphp
            Swal.fire({
                ...swalConfig,
                title: @json($cfg['title'] ?? ''),
                text:  @json($cfg['text']  ?? ''),
                icon:  @json($cfg['icon']  ?? 'info'),
            });
            @endif

        });
    </script>
</body>
</html>