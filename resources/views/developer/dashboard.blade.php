<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Developer - Garuda-Hub</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <nav class="navbar">
        <a href="{{ route('home') }}" class="navbar-brand">Garuda<span>Hub</span></a>
        <div class="nav-links">
            <a href="{{ route('home') }}">Cari Proyek</a>
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-outline btn-sm">Keluar</button>
            </form>
        </div>
    </nav>

    <main class="container">
        <h2 style="margin-bottom:6px;">Dashboard Developer — {{ $user->nama }}</h2>
        <p style="color:#64748b; margin-bottom:24px;">Keahlian: {{ $user->keahlian ?? '-' }}</p>

        <div class="card">
            <h3 style="margin-bottom:12px;">Riwayat Penawaran Saya ({{ $myBids->count() }})</h3>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Proyek</th>
                            <th>Klien</th>
                            <th>Harga Tawaran</th>
                            <th>Estimasi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($myBids as $bid)
                            <tr>
                                <td><strong>{{ $bid->project->judul }}</strong></td>
                                <td>{{ $bid->project->klien->nama }}</td>
                                <td>Rp {{ number_format($bid->harga_tawaran, 0, ',', '.') }}</td>
                                <td>{{ $bid->estimasi_hari }} Hari</td>
                                <td>
                                    <span class="badge {{ $bid->status === 'diterima' ? 'badge-open' : ($bid->status === 'ditolak' ? 'badge-closed' : 'badge-cat') }}">
                                        {{ strtoupper($bid->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('projects.show', $bid->project) }}" class="btn btn-red btn-sm">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6">Anda belum mengajukan penawaran pada proyek mana pun.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>
