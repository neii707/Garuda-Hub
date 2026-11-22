<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Garuda-Hub - Marketplace Lelang Proyek IT</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <nav class="navbar">
        <a href="{{ route('home') }}" class="navbar-brand">Garuda<span>Hub</span></a>
        <div class="nav-links">
            <a href="{{ route('home') }}">Jelajah Proyek</a>
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-red btn-sm">Dashboard ({{ Auth::user()->nama }})</a>
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-outline btn-sm">Keluar</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline btn-sm">Masuk</a>
                <a href="{{ route('register') }}" class="btn btn-red btn-sm">Daftar</a>
            @endauth
        </div>
    </nav>

    <section class="hero">
        <h1>Temukan Developer Terbaik untuk Proyek Digitalmu</h1>
        <p>Platform lelang proyek IT transparan yang mempertemukan pemilik bisnis dengan talenta developer terbaik Indonesia.</p>

        <form action="{{ route('home') }}" method="GET" class="search-bar">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul atau deskripsi proyek...">
            <select name="kategori">
                <option value="">Semua Kategori</option>
                <option value="Web Development" {{ request('kategori') == 'Web Development' ? 'selected' : '' }}>Web Development</option>
                <option value="Mobile App" {{ request('kategori') == 'Mobile App' ? 'selected' : '' }}>Mobile App</option>
                <option value="UI/UX Design" {{ request('kategori') == 'UI/UX Design' ? 'selected' : '' }}>UI/UX Design</option>
            </select>
            <button type="submit" class="btn btn-red">Cari</button>
        </form>
    </section>

    <main class="container">
        <div class="section-header">
            <h2>Daftar Proyek Tersedia ({{ $projects->count() }})</h2>
        </div>

        <div class="grid-3">
            @forelse ($projects as $project)
                <div class="card">
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <span class="badge badge-cat">{{ $project->kategori }}</span>
                        <span class="badge {{ $project->status === 'terbuka' ? 'badge-open' : 'badge-closed' }}">
                            {{ strtoupper($project->status) }}
                        </span>
                    </div>

                    <h3 class="project-title">{{ $project->judul }}</h3>
                    <p class="project-desc">{{ \Illuminate\Support\Str::limit($project->deskripsi, 110) }}</p>
                    <p style="font-size:12px; color:#64748b; margin-bottom:12px;">
                        Klien: <strong>{{ $project->klien->nama }}</strong> • {{ $project->bids->count() }} Penawaran
                    </p>

                    <div class="project-meta">
                        <div>
                            <small style="color:#64748b; display:block;">Anggaran Maksimal</small>
                            <span class="budget">Rp {{ number_format($project->anggaran, 0, ',', '.') }}</span>
                        </div>
                        <a href="{{ route('projects.show', $project) }}" class="btn btn-red btn-sm">Detail & Bid</a>
                    </div>
                </div>
            @empty
                <div class="card" style="grid-column: 1 / -1; text-align:center;">
                    <p>Belum ada proyek yang sesuai pencarian.</p>
                </div>
            @endforelse
        </div>
    </main>
</body>
</html>