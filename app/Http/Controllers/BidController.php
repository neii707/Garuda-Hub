<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Project;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BidController extends Controller
{
    public function store(Request $request, Project $project)
    {
        abort_if(Auth::user()->role !== 'developer', 403, 'Hanya developer yang dapat mengajukan penawaran.');

        if ($project->status !== 'terbuka' || $project->batas_lelang < now()->toDateString()) {
            return redirect()->route('projects.show', $project->id)
                ->with('error', 'Lelang sudah ditutup; penawaran tidak dapat diajukan.');
        }

        $data = $request->validate([
            'harga' => ['required', 'integer', 'min:1', 'max:999999999999'],
            'durasi' => ['required', 'integer', 'min:1', 'max:3650'],
            'proposal' => ['required', 'string', 'max:5000'],
        ]);

        try {
            Bid::create([
                'project_id' => $project->id,
                'developer_id' => Auth::id(),
                'harga' => $data['harga'],
                'durasi' => $data['durasi'],
                'proposal' => trim($data['proposal']),
            ]);
        } catch (QueryException $e) {
            if (($e->errorInfo[1] ?? 0) === 1062) {
                return redirect()->route('projects.show', $project->id)
                    ->with('error', 'Anda sudah mengajukan penawaran pada proyek ini.');
            }
            throw $e;
        }

        return redirect()->route('projects.show', $project->id)->with('success', 'Penawaran berhasil dikirim.');
    }

    public function pick(Project $project, Bid $bid)
    {
        abort_if(Auth::user()->role !== 'klien' || $project->client_id !== Auth::id(), 403);

        $err = DB::transaction(function () use ($project, $bid) {
            $locked = Project::where('id', $project->id)->where('client_id', Auth::id())->lockForUpdate()->first();
            if (!$locked || $locked->status !== 'terbuka') {
                return 'Pemenang sudah dipilih atau lelang sudah ditutup.';
            }
            if ($bid->project_id !== $locked->id) {
                return 'Penawaran tidak valid untuk proyek ini.';
            }
            $bid->update(['is_winner' => 1]);
            $locked->update(['status' => 'ditutup']);
            return '';
        });

        if ($err !== '') {
            return redirect()->route('projects.show', $project->id)->with('error', $err);
        }

        return redirect()->route('projects.show', $project->id)->with('success', 'Pemenang berhasil dipilih.');
    }
}