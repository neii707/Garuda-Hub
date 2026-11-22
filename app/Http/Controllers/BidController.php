<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BidController extends Controller
{
    public function store(Request $request, Project $project)
    {
        abort_unless(Auth::user()->role === 'developer', 403);
        abort_if($project->status !== 'terbuka', 400, 'Lelang proyek sudah ditutup.');

        $data = $request->validate([
            'harga_tawaran' => ['required', 'integer', 'min:50000'],
            'estimasi_hari' => ['required', 'integer', 'min:1'],
            'proposal' => ['required', 'string'],
        ]);

        Bid::updateOrCreate(
            [
                'project_id' => $project->id,
                'developer_id' => Auth::id(),
            ],
            [
                'harga_tawaran' => $data['harga_tawaran'],
                'estimasi_hari' => $data['estimasi_hari'],
                'proposal' => $data['proposal'],
                'status' => 'menunggu',
            ]
        );

        return redirect()->route('projects.show', $project)->with('success', 'Penawaran berhasil dikirim.');
    }
}
