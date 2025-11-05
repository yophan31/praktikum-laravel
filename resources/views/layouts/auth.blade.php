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

    <style>
        body {
            background-color: #f5f7fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .auth-container {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            padding: 30px;
            width: 400px;
            text-align: center;
        }
        .auth-container img {
            width: 150px;
            margin-bottom: 15px;
        }
        .app-title {
            font-weight: 700;
            color: #007bff;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="auth-container">
        {{-- Gambar di atas form --}}
        <h3 class="app-title">Catatan Keuangan</h3>

        {{-- Konten dari login/register --}}
        @yield('content')
    </div>

    {{-- Scripts --}}
    @livewireScripts
    <script src="/assets/vendor/bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
