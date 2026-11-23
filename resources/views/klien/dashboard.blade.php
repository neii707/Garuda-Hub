@extends('layouts.app')
@section('title', 'Dasbor')

@section('content')
<div class="card">
    <h1>Proyek Saya</h1>
    <p><a href="{{ route('projects.create') }}">Pasang proyek baru</a></p>
</div>

@forelse($projects as $p)
<div class="card">
    <h2>
        <a href="{{ route('projects.show', $p->id) }}">{{ $p->judul }}</a>
        <span class="badge {{ $p->status === 'terbuka' ? 'open' : 'closed' }}">{{ $p->status }}</span>
    </h2>
    <p class="muted">
        Budget: Rp {{ number_format($p->budget_min, 0, ',', '.') }} - Rp {{ number_format($p->budget_max, 0, ',', '.') }} |
        Batas: {{ $p->batas_lelang }} |
        {{ $p->bids_count }} penawaran
    </p>
</div>
@empty
<div class="card"><p>Anda belum memasang proyek.</p></div>
@endforelse
@endsection