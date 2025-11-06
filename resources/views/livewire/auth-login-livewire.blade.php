<div class="d-flex justify-content-center align-items-center min-vh-100" style="background-color: #f8f9fa;">
    <form wire:submit.prevent="login" class="w-100" style="max-width: 360px;">
        <div class="card mx-auto shadow-sm border-0">
            <div class="card-body">
                <div class="text-center mb-3">
                    <img src="/logo.png" alt="Logo" style="width: 100px; height: auto; margin-bottom: 10px;">
                    <h2 class="fw-bold">Masuk</h2>
                </div>
                <hr>

                {{-- Alamat Email --}}
                <div class="form-group mb-3">
                    <label>Email</label>
                    <input type="email" class="form-control" wire:model="email" placeholder="Masukkan email">
                    @error('email')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Kata Sandi --}}
                <div class="form-group mb-3">
                    <label>Kata Sandi</label>
                    <input type="password" class="form-control" wire:model="password" placeholder="Masukkan kata sandi">
                    @error('password')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Tombol Kirim --}}
                <div class="form-group mt-3 text-end">
                    <button type="submit" class="btn btn-primary w-100">Kirim</button>
                </div>

                <hr>
                <p class="text-center mb-0">Belum memiliki akun?
                    <a href="{{ route('auth.register') }}">Daftar</a>
                </p>
            </div>
        </div>
    </form>
</div>

@section('others-css')
    <link rel="stylesheet" href="/assets/vendor/node_modules/sweetalert2/dist/sweetalert2.min.css">
@endsection

@section('others-js')
    <script src="/assets/vendor/node_modules/sweetalert2/dist/sweetalert2.min.js"></script>

    <script>
        document.addEventListener("livewire:init", () => {
            Livewire.on("showError", (data) => {
                Swal.fire({
                    icon: "error",
                    title: "Gagal Masuk",
                    text: data.message,
                });
            });
        });
    </script>
@endsection
