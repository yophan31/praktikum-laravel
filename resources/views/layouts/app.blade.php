<!doctype html>
<html lang="id">

<head>
    {{-- Meta --}}
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Icon --}}
    <link rel="icon" href="/logo.png" type="image/x-icon" />

    {{-- Judul --}}
    <title>Aplikasi Catatan Keuangan</title>

    {{-- Styles --}}
    @livewireStyles
    <link rel="stylesheet" href="/assets/vendor/bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/vendor/sweetalert2/sweetalert2.min.css">
    @yield('styles')
</head>

<body>
    <div class="container">
        @yield('content')
    </div>

    {{-- Scripts --}}
    @livewireScripts
    <script src="/assets/vendor/bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/vendor/sweetalert2/sweetalert2.all.min.js"></script>
    
    @yield('scripts')

    <script>
        // Listen untuk Livewire events
        document.addEventListener('livewire:init', () => {
            // Show Modal
            Livewire.on('showModal', (data) => {
                const modal = new bootstrap.Modal(document.getElementById(data.id));
                modal.show();
            });

            // Close Modal
            Livewire.on('closeModal', (data) => {
                const modal = bootstrap.Modal.getInstance(document.getElementById(data.id));
                if (modal) {
                    modal.hide();
                }
            });

            // Show Alert dengan SweetAlert2
            Livewire.on('showAlert', (data) => {
                Swal.fire({
                    icon: data.icon || 'info',
                    title: data.title || 'Info',
                    text: data.text || '',
                    confirmButtonText: 'OK'
                });
            });
        });
    </script>
</body>

</html>