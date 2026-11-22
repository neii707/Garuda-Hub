<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Klien - Garuda-Hub</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <nav class="navbar">
        <a href="{{ route('home') }}" class="navbar-brand">Garuda<span>Hub</span></a>
        <div class="nav-links">
            <a href="{{ route('home') }}">Beranda</a>
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-outline btn-sm">Keluar</button>
            </form>
        </div>
    </nav>

    <main class="container">
        <h2 style="margin-bottom:20px;">Dashboard Klien — Halo, {{ $user->nama }}</h2>

        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <div class="card" style="margin-bottom:28px;">
            <h3 style="margin-bottom:16px;">Buat Proyek Baru</h3>
            <form action="{{ route('projects.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Judul Proyek</label>
                    <input type="text" name="judul" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Kategori</label>
                    <select name="kategori" class="form-control" required>
                        <option value="Web Development">Web Development</option>
                        <option value="Mobile App">Mobile App</option>
                        <option value="UI/UX Design">UI/UX Design</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Deskripsi Kebutuhan</label>
                    <textarea name="deskripsi" rows="3" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label>Anggaran (Rp)</label>
                    <input type="number" name="anggaran" class="form-control" min="50000" required>
                </div>
                <div class="form-group">
                    <label>Batas Akhir Lelang</label>
                    <input type="date" name="batas_lelang" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-red">Publikasikan Proyek</button>
            </form>
        </div>

        <div class="card">
            <h3 style="margin-bottom:12px;">Proyek Saya ({{ $projects->count() }})</h3>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Judul Proyek</th>
                            <th>Anggaran</th>
                            <th>Jumlah Bid</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($projects as $project)
                            <tr>
                                <td><strong>{{ $project->judul }}</strong></td>
                                <td>Rp {{ number_format($project->anggaran, 0, ',', '.') }}</td>
                                <td>{{ $project->bids->count() }} Penawaran</td>
                                <td>
                                    <span class="badge {{ $project->status === 'terbuka' ? 'badge-open' : 'badge-closed' }}">
                                        {{ strtoupper($project->status) }}
                                    </span>
                                </td>
                                <td style="display:flex; gap:8px;">
                                    <a href="{{ route('projects.show', $project) }}" class="btn btn-success btn-sm">Lihat Bid</a>
                                    <form action="{{ route('projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Hapus proyek ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-red btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5">Belum ada proyek yang dibuat.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>