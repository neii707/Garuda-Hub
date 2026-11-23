<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        abort_if(Auth::user()->role !== 'admin', 403);

        $users = User::orderBy('id')->get();
        $projects = Project::with('klien')->orderByDesc('id')->get();

        return view('admin.index', compact('users', 'projects'));
    }

    public function updateRole(Request $request, User $user)
    {
        abort_if(Auth::user()->role !== 'admin', 403);

        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat mengubah peran akun sendiri.');
        }

        $data = $request->validate([
            'role' => ['required', 'in:klien,developer,admin'],
        ]);

        $user->update(['role' => $data['role']]);

        return back()->with('success', 'Peran user diubah.');
    }

    public function destroyUser(User $user)
    {
        abort_if(Auth::user()->role !== 'admin', 403);

        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return back()->with('success', 'User dihapus.');
    }

    public function destroyProject(Project $project)
    {
        abort_if(Auth::user()->role !== 'admin', 403);

        $project->delete();

        return back()->with('success', 'Proyek dihapus.');
    }
}