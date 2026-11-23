<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function show(Project $project)
    {
        $project->load([
            'klien',
            'bids' => fn($q) => $q->with('developer')->orderByDesc('is_winner')->orderBy('harga')->orderBy('id'),
        ]);

        return view('projects.show', compact('project'));
    }

    public function create()
    {
        abort_if(Auth::user()->role !== 'klien', 403, 'Hanya klien yang dapat memasang proyek.');
        return view('projects.create');
    }

    public function store(Request $request)
    {
        abort_if(Auth::user()->role !== 'klien', 403, 'Hanya klien yang dapat memasang proyek.');

        $data = $request->validate([
            'judul' => ['required', 'string', 'max:200'],
            'deskripsi' => ['required', 'string', 'max:5000'],
            'kategori' => ['required', 'string', 'max:50'],
            'budget_min' => ['required', 'integer', 'min:0', 'max:999999999999'],
            'budget_max' => ['required', 'integer', 'gte:budget_min', 'max:999999999999'],
            'batas_lelang' => ['required', 'date', 'after_or_equal:today'],
        ]);

        Project::create([
            'client_id' => Auth::id(),
            'judul' => trim($data['judul']),
            'deskripsi' => trim($data['deskripsi']),
            'kategori' => trim($data['kategori']),
            'budget_min' => $data['budget_min'],
            'budget_max' => $data['budget_max'],
            'batas_lelang' => $data['batas_lelang'],
            'status' => 'terbuka',
        ]);

        return redirect()->route('dashboard')->with('success', 'Proyek berhasil dipasang.');
    }
}