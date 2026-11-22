<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $project->judul }} - Garuda-Hub</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <nav class="navbar">
        <a href="{{ route('home') }}" class="navbar-brand">Garuda<span>Hub</span></a>
        <div class="nav-links">
            <a href="{{ route('home') }}">Beranda</a>
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-red btn-sm">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-red btn-sm">Masuk untuk Bid</a>
            @endauth
        </div>
    </nav>

    <main class="container">
        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <div class="card" style="margin-bottom:24px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
                <span class="badge badge-cat">{{ $project->kategori }}</span>
                <span class="badge {{ $project->status === 'terbuka' ? 'badge-open' : 'badge-closed' }}">
                    Status: {{ strtoupper($project->status) }}
                </span>
            </div>

            <h1 style="font-size:26px; margin-bottom:8px;">{{ $project->judul }}</h1>
            <p style="font-size:14px; color:#64748b; margin-bottom:18px;">
                Diposting oleh <strong>{{ $project->klien->nama }}</strong> • Batas Lelang: <strong>{{ $project->batas_lelang }}</strong>
            </p>

            <p style="margin-bottom:20px; white-space:pre-line;">{{ $project->deskripsi }}</p>

            <div style="background:#f8fafc; padding:16px; border-radius:10px; border:1px solid #e2e8f0;">
                <small style="color:#64748b;">Anggaran Proyek</small>
                <div class="budget" style="font-size:22px;">Rp {{ number_format($project->anggaran, 0, ',', '.') }}</div>
            </div>
        </div>

        @auth
            @if (Auth::user()->role === 'developer' && $project->status === 'terbuka')
                <div class="card" style="margin-bottom:24px;">
                    <h3 style="margin-bottom:16px;">Ajukan Penawaran (Bid)</h3>
                    <form action="{{ route('bids.store', $project) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Harga Penawaran (Rp)</label>
                            <input type="number" name="harga_tawaran" class="form-control" required min="50000">
                        </div>
                        <div class="form-group">
                            <label>Estimasi Pengerjaan (Hari)</label>
                            <input type="number" name="estimasi_hari" class="form-control" required min="1">
                        </div>
                        <div class="form-group">
                            <label>Proposal Singkat</label>
                            <textarea name="proposal" rows="4" class="form-control" required placeholder="Jelaskan rencana pengerjaan dan teknologi yang digunakan..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-red">Kirim Penawaran</button>
                    </form>
                </div>
            @endif
        @endauth

        <div class="card">
            <h3 style="margin-bottom:16px;">Daftar Penawaran Masuk ({{ $project->bids->count() }})</h3>
            @forelse ($project->bids as $bid)
                <div style="border:1px solid #e2e8f0; border-radius:10px; padding:16px; margin-bottom:12px;">
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <div>
                            <strong>{{ $bid->developer->nama }}</strong>
                            <small style="color:#64748b;">({{ $bid->developer->keahlian ?? 'Developer' }})</small>
                        </div>
                        <span class="badge {{ $bid->status === 'diterima' ? 'badge-open' : ($bid->status === 'ditolak' ? 'badge-closed' : 'badge-cat') }}">
                            {{ strtoupper($bid->status) }}
                        </span>
                    </div>
                    <p style="margin:10px 0; font-size:14px;">{{ $bid->proposal }}</p>
                    <div style="display:flex; justify-content:space-between; align-items:center; font-size:14px;">
                        <span>Tawaran: <strong style="color:#dc2626;">Rp {{ number_format($bid->harga_tawaran, 0, ',', '.') }}</strong> • Estimasi: <strong>{{ $bid->estimasi_hari }} Hari</strong></span>

                        @auth
                            @if (Auth::id() === $project->klien_id && $project->status === 'terbuka')
                                <form action="{{ route('projects.winner', [$project, $bid]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Pilih Pemenang</button>
                                </form>
                            @endif
                        @endauth
                    </div>
                </div>
            @empty
                <p style="color:#64748b;">Belum ada developer yang mengajukan penawaran.</p>
            @endforelse
        </div>
    </main>
</body>
</html>
