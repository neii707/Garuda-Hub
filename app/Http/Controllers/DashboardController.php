<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $u = Auth::user();
        abort_if($u->role === 'admin', 403);

        if ($u->role === 'klien') {
            $projects = Project::withCount('bids')
                ->where('client_id', $u->id)
                ->orderByDesc('id')
                ->get();

            return view('klien.dashboard', compact('projects'));
        }

        $bids = Bid::with(['project.klien'])
            ->where('developer_id', $u->id)
            ->orderByDesc('id')
            ->get();

        return view('developer.dashboard', compact('bids'));
    }
}