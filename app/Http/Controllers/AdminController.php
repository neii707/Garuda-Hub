<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        abort_unless(Auth::user()->role === 'admin', 403);

        $users = User::latest()->get();
        $projects = Project::with(['klien', 'bids'])->latest()->get();
        $bids = Bid::with(['project', 'developer'])->latest()->get();

        return view('admin.index', compact('users', 'projects', 'bids'));
    }

    public function destroyUser(User $user)
    {
        abort_unless(Auth::user()->role === 'admin', 403);
        abort_if($user->id === Auth::id(), 400, 'Tidak dapat menghapus akun sendiri.');

        $user->delete();

        return back()->with('success', 'Pengguna berhasil dihapus.');
    }
}
