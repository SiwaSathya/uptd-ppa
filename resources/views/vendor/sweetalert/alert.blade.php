@if(Session::has('alert.config'))
@php
    $config = Session::get('alert.config');
    // Bisa jadi string JSON atau array, normalize dulu
    if (is_string($config)) {
        $config = json_decode($config, true);
    }
@endphp
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<script>
    window.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            title: @json($config['title'] ?? ''),
            text:  @json($config['text']  ?? ''),
            icon:  @json($config['icon']  ?? 'info'),

            confirmButtonColor: '#435ebe',
            confirmButtonText:  'OK',

            customClass: {
                popup:         'swal-popup-custom',
                title:         'swal-title-custom',
                confirmButton: 'swal-btn-custom',
            },

            showClass: {
                popup: 'animate__animated animate__fadeInDown animate__faster'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp animate__faster'
            },

            timer:            2800,
            timerProgressBar: true,
        });
    });
</script>

<style>
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
    }
    .swal-btn-custom:hover {
        background: linear-gradient(135deg, #3450aa, #435ebe) !important;
        transform: translateY(-1px) !important;
    }
    .swal2-timer-progress-bar {
        background: linear-gradient(90deg, #435ebe, #6478d4) !important;
    }
</style>
@endif