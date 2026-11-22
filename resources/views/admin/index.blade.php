<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Garuda-Hub</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <nav class="navbar">
        <a href="{{ route('home') }}" class="navbar-brand">Garuda<span>Hub</span> Admin</a>
        <div class="nav-links">
            <a href="{{ route('home') }}">Lihat Situs</a>
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-outline btn-sm">Keluar</button>
            </form>
        </div>
    </nav>

    <main class="container">
        <h2 style="margin-bottom:20px;">Panel Administrator Garuda-Hub</h2>

        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <div class="card" style="margin-bottom:28px;">
            <h3>Manajemen Pengguna ({{ $users->count() }})</h3>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $u)
                            <tr>
                                <td>{{ $u->nama }}</td>
                                <td>{{ $u->email }}</td>
                                <td><span class="badge badge-cat">{{ strtoupper($u->role) }}</span></td>
                                <td>
                                    @if ($u->id !== Auth::id())
                                        <form action="{{ route('admin.users.destroy', $u) }}" method="POST" onsubmit="return confirm('Hapus pengguna ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-red btn-sm">Hapus</button>
                                        </form>
                                    @else
                                        <small style="color:#64748b;">Akun Aktif</small>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <h3>Semua Proyek Lelang ({{ $projects->count() }})</h3>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Klien</th>
                            <th>Anggaran</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($projects as $p)
                            <tr>
                                <td>{{ $p->judul }}</td>
                                <td>{{ $p->klien->nama }}</td>
                                <td>Rp {{ number_format($p->anggaran, 0, ',', '.') }}</td>
                                <td>{{ strtoupper($p->status) }}</td>
                                <td>
                                    <form action="{{ route('projects.destroy', $p) }}" method="POST" onsubmit="return confirm('Hapus proyek ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-red btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>
