<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Garuda-Hub</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
    <div class="auth-wrapper" style="max-width: 520px;">
        <div class="brand-header">
            <span class="brand-badge">BERGABUNG BERSAMA KAMI</span>
            <h1>Buat Akun Garuda-Hub</h1>
            <p>Pilih peran sebagai Klien pemilik proyek atau Developer</p>
        </div>

        @if ($errors->any())
            <div class="alert-error">
                <ul style="padding-left: 18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.post') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" class="form-control" value="{{ old('nama') }}" required>
            </div>

            <div class="form-group">
                <label for="email">Alamat Email</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label for="role">Daftar Sebagai</label>
                <select id="role" name="role" class="form-control" required>
                    <option value="klien" {{ old('role') == 'klien' ? 'selected' : '' }}>Klien (Pemilik Proyek)</option>
                    <option value="developer" {{ old('role') == 'developer' ? 'selected' : '' }}>Developer (Freelancer IT)</option>
                </select>
            </div>

            <div class="form-group">
                <label for="keahlian">Keahlian Utama (Khusus Developer)</label>
                <input type="text" id="keahlian" name="keahlian" class="form-control" value="{{ old('keahlian') }}" placeholder="Contoh: Laravel, React, UI/UX">
            </div>

            <div class="form-group">
                <label for="password">Kata Sandi</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Kata Sandi</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn-primary">Daftar Akun</button>
        </form>

        <div class="auth-footer">
            Sudah memiliki akun? <a href="{{ route('login') }}">Masuk di sini</a>
        </div>
    </div>
</body>
</html>