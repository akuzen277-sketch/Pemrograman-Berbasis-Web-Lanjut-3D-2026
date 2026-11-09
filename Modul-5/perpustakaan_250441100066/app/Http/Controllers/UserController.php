<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    // Menampilkan daftar pengguna dan rolenya
    public function index()
    {
        abort_unless(
            auth()->user()->can('kelola data pengguna') || auth()->user()->can('kelola role pengguna'),
            403,
            'Anda tidak memiliki hak akses untuk mengelola data pengguna.'
        );

        $users = User::with(['roles', 'anggota'])->latest()->get();
        $roles = Role::all();

        return view('users.index', compact('users', 'roles'));
    }

    // Mengubah role pengguna
    public function updateRole(Request $request, User $user)
    {
        abort_unless(
            auth()->user()->can('kelola role pengguna'),
            403,
            'Anda tidak memiliki hak akses untuk mengubah role pengguna.'
        );

        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        // Mencegah admin menghapus role admin dari akunnya sendiri jika sedang login
        if ($user->id === auth()->id() && $request->role !== 'admin') {
            return back()->with('error', 'Anda tidak dapat mencabut role admin dari akun Anda sendiri.');
        }

        $user->syncRoles([$request->role]);

        return back()->with('success', "Role pengguna {$user->name} berhasil diubah menjadi {$request->role}.");
    }

    // Menghapus pengguna
    public function destroy(User $user)
    {
        abort_unless(
            auth()->user()->can('kelola data pengguna'),
            403,
            'Anda tidak memiliki hak akses untuk menghapus pengguna.'
        );

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return back()->with('success', "Pengguna {$user->name} berhasil dihapus.");
    }
}
