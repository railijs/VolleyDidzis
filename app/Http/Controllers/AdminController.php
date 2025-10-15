<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tournament;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * If the current user is not an admin, redirect to dashboard with a flash message.
     * Returns null when the user IS admin (caller may proceed).
     */
    private function adminOrRedirect(): ?RedirectResponse
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return redirect()
                ->route('dashboard')
                ->with('error', 'Only admins can access that page.');
        }
        return null;
    }

    public function dashboard(): View|RedirectResponse
    {
        if ($r = $this->adminOrRedirect()) return $r;

        $totalUsers        = User::count();
        $activeTournaments = Tournament::where('status', 'active')->count();
        $newsCount         = News::count();
        $adminCount        = User::where('role', 'admin')->count();

        $users = User::orderBy('created_at', 'desc')->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'activeTournaments',
            'newsCount',
            'adminCount',
            'users'
        ));
    }

    public function users(): View|RedirectResponse
    {
        if ($r = $this->adminOrRedirect()) return $r;

        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.users', compact('users'));
    }

    // Delete a user
    public function destroyUser(User $user): RedirectResponse
    {
        if ($r = $this->adminOrRedirect()) return $r;

        if (auth()->id() === $user->id) {
            return back()->with('error', 'You cannot delete yourself!');
        }

        $user->delete();

        return back()->with('success', 'User deleted successfully.');
    }

    public function updateRole(Request $request, User $user): RedirectResponse
    {
        if ($r = $this->adminOrRedirect()) return $r;

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
