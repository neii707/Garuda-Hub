<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.index');
        }

        if ($user->role === 'klien') {
            $projects = Project::with(['bids.developer', 'pemenangBid.developer'])
                ->where('klien_id', $user->id)
                ->latest()
                ->get();

            return view('klien.dashboard', compact('user', 'projects'));
        }

        $myBids = Bid::with(['project.klien'])
            ->where('developer_id', $user->id)
            ->latest()
            ->get();

        $openProjects = Project::with(['klien', 'bids'])
            ->where('status', 'terbuka')
            ->latest()
            ->get();

        return view('developer.dashboard', compact('user', 'myBids', 'openProjects'));
    }
}
