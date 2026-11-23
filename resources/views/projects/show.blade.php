@extends('layouts.app')
@section('title', $project->judul)

@section('content')
@php
    $u = auth()->user();
    $owner = $u && $u->role === 'klien' && $u->id === $project->client_id;
    $open = $project->status === 'terbuka' && $project->batas_lelang >= now()->toDateString();
@endphp

<div class="card">
    <h1>
        {{ $project->judul }}
        <span class="badge {{ $project->status === 'terbuka' ? 'open' : 'closed' }}">{{ $project->status }}</span>
    </h1>
    <p class="muted">
        Kategori: {{ $project->kategori }} |
        Klien: {{ $project->klien?->nama ?? '-' }} |
        Budget: Rp {{ number_format($project->budget_min, 0, ',', '.') }} - Rp {{ number_format($project->budget_max, 0, ',', '.') }} |
        Batas lelang: {{ $project->batas_lelang }}
    </p>
    <p>{!! nl2br(e($project->deskripsi)) !!}</p>
</div>

<div class="card">
    <h2>Penawaran ({{ $project->bids->count() }})</h2>
    @if($project->bids->isEmpty())
        <p>Belum ada penawaran.</p>
    @else
        <table>
            <tr>
                <th>Developer</th>
                <th>Harga</th>
                <th>Durasi</th>
                <th>Proposal</th>
                <th></th>
            </tr>
            @foreach($project->bids as $b)
            <tr class="{{ $b->is_winner ? 'winner' : '' }}">
                <td>
                    {{ $b->developer?->nama ?? '-' }}
                    @if($b->is_winner) <span class="badge win">Pemenang</span> @endif
                </td>
                <td>Rp {{ number_format($b->harga, 0, ',', '.') }}</td>
                <td>{{ $b->durasi }} hari</td>
                <td>{!! nl2br(e($b->proposal)) !!}</td>
                <td>
                    @if($owner && $project->status === 'terbuka')
                    <form method="POST" action="{{ route('bids.pick', [$project->id, $b->id]) }}" onsubmit="return confirm('Pilih penawaran ini sebagai pemenang?')">
                        @csrf
                        <button class="sm" type="submit">Pilih pemenang</button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </table>
    @endif
</div>

@if($u && $u->role === 'developer')
    @if($open)
    <div class="card">
        <h2>Ajukan Penawaran</h2>
        <form method="POST" action="{{ route('bids.store', $project->id) }}">
            @csrf
            <div class="row">
                <div>
                    <label>Harga (Rp)</label>
                    <input type="number" name="harga" min="1" required>
                </div>
                <div>
                    <label>Durasi (hari)</label>
                    <input type="number" name="durasi" min="1" required>
                </div>
            </div>
            <label>Proposal</label>
            <textarea name="proposal" required></textarea>
            <p><button type="submit">Kirim penawaran</button></p>
        </form>
    </div>
    @else
    <div class="card"><p class="muted">Lelang sudah ditutup; penawaran tidak dapat diajukan.</p></div>
    @endif
@elseif(!$u && $open)
    <div class="card"><p><a href="{{ route('login') }}">Masuk</a> sebagai developer untuk mengajukan penawaran.</p></div>
@endif
@endsection