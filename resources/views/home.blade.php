@extends('layouts.app')
@section('title', 'Proyek')

@section('content')
<div class="card">
    <h1>Daftar Proyek</h1>
    <form class="search" method="GET" action="{{ route('home') }}">
        <input name="q" maxlength="100" placeholder="Cari judul atau kategori..." value="{{ request('q') }}">
        <button>Cari</button>
    </form>
    @if(request('q'))
        <p class="muted">Hasil pencarian untuk: <b>{{ request('q') }}</b> ({{ $projects->count() }} proyek)</p>
    @endif
</div>

@forelse($projects as $p)
<div class="card">
    <h2>
        <a href="{{ route('projects.show', $p->id) }}">{{ $p->judul }}</a>
        <span class="badge {{ $p->status === 'terbuka' ? 'open' : 'closed' }}">{{ $p->status }}</span>
    </h2>
    <p class="muted">
        Kategori: {{ $p->kategori }} |
        Klien: {{ $p->klien?->nama ?? '-' }} |
        Budget: Rp {{ number_format($p->budget_min, 0, ',', '.') }} - Rp {{ number_format($p->budget_max, 0, ',', '.') }} |
        Batas: {{ $p->batas_lelang }} |
        {{ $p->bids->count() }} penawaran
    </p>
    <p>{{ \Illuminate\Support\Str::limit($p->deskripsi, 160) }}</p>
</div>
@empty
<div class="card"><p>Belum ada proyek yang cocok.</p></div>
@endforelse
@endsection