<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $q = mb_substr(trim((string)$request->query('q', '')), 0, 100);

        $projects = Project::with(['klien', 'bids'])
            ->when($q !== '', function ($query) use ($q) {$like = '%' . addcslashes($q, '\\%_') . '\%';$query->where(function ($sub) use ($like) {
                    $sub->where('judul', 'like',$like)
                        ->orWhere('kategori', 'like', $like);
                });
            })
            ->orderByDesc('id')
            ->get();

        return view('home', compact('projects'));
    }
}