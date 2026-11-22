<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Garuda-Hub</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
    <div class="auth-wrapper">
        <div class="brand-header">
            <span class="brand-badge">GARUDA-HUB PLATFORM</span>
            <h1>Selamat Datang Kembali</h1>
            <p>Masuk untuk mengelola proyek atau mengajukan penawaran</p>
        </div>

        @if ($errors->any())
            <div class="alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Alamat Email</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="contoh@garudahub.id" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Kata Sandi</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn-primary">Masuk Sekarang</button>
        </form>

        <div class="auth-footer">
            Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a><br><br>
            <a href="{{ route('home') }}" style="color:#64748b;font-weight:500;">← Kembali ke Beranda</a>
        </div>
    </div>
</body>
</html>