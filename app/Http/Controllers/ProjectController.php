<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function show(Project $project)
    {
        $project->load(['klien', 'bids.developer', 'pemenangBid.developer']);
        return view('projects.show', compact('project'));
    }

    public function store(Request $request)
    {
        abort_unless(Auth::user()->role === 'klien', 403);

        $data = $request->validate([
            'judul' => ['required', 'string', 'max:150'],
            'kategori' => ['required', 'string', 'max:100'],
            'deskripsi' => ['required', 'string'],
            'anggaran' => ['required', 'integer', 'min:50000'],
            'batas_lelang' => ['required', 'date', 'after_or_equal:today'],
        ]);

        Project::create([
            'klien_id' => Auth::id(),
            'judul' => $data['judul'],
            'kategori' => $data['kategori'],
            'deskripsi' => $data['deskripsi'],
            'anggaran' => $data['anggaran'],
            'batas_lelang' => $data['batas_lelang'],
            'status' => 'terbuka',
        ]);

        return redirect()->route('dashboard')->with('success', 'Proyek berhasil dipublikasikan.');
    }

    public function selectWinner(Project $project, Bid $bid)
    {
        abort_unless(Auth::id() === $project->klien_id, 403);
        abort_unless($bid->project_id === $project->id, 404);

        $project->bids()->where('id', '!=', $bid->id)->update(['status' => 'ditolak']);
        $bid->update(['status' => 'diterima']);

        $project->update([
            'status' => 'ditutup',
            'pemenang_bid_id' => $bid->id,
        ]);

        return back()->with('success', 'Pemenang lelang berhasil dipilih.');
    }

    public function destroy(Project $project)
    {
        $user = Auth::user();
        abort_unless($user->role === 'admin' || $user->id === $project->klien_id, 403);

        $project->delete();

        return back()->with('success', 'Proyek berhasil dihapus.');
    }
}
