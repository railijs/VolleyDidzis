<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tournament;
use App\Models\News;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Admin panel dashboard
    public function dashboard()
    {
        $totalUsers = User::count();
        $activeTournaments = Tournament::where('status', 'active')->count();
        $newsCount = News::count();
        $adminCount = User::where('role', 'admin')->count();

        $users = User::orderBy('created_at', 'desc')->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'activeTournaments',
            'newsCount',
            'adminCount',
            'users'
        ));
    }

    // Show all users
    public function users()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.users', compact('users'));
    }

    // Delete a user
    public function destroyUser(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'You cannot delete yourself!');
        }

        $user->delete();

        return back()->with('success', 'User deleted successfully.');
    }

    // Update user role
    public function updateRole(Request $request, User $user)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'role' => 'required|in:user,teacher,admin',
        ]);

        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot change your own role.');
        }

        $user->update(['role' => $request->role]);

        return back()->with('success', 'User role updated successfully.');
    }
}
