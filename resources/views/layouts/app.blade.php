<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Catatan Keuangan - Laravel App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.min.css">
    @yield('styles')
</head>

<body>
    <div class="container">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js"></script>
    
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