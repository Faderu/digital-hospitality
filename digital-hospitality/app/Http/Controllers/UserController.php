<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Poli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Database\QueryException;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
        if ($request->role) {
            $query->where('role', $request->role);
        }
        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        $users = $query->orderBy('name')->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $polis = Poli::all();
        return view('admin.users.create', compact('polis'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required|in:admin,doctor,patient',
            'poli_id' => 'required_if:role,doctor|exists:polis,id',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);

        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $polis = Poli::all();
        return view('admin.users.edit', compact('user', 'polis'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,doctor,patient',
            'poli_id' => 'required_if:role,doctor|exists:polis,id',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);
        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        // FIX: Mencegah error SQL jika user memiliki data relasi (foreign key)
        try {
            $user->delete();
            return redirect()->route('users.index')->with('success', 'User deleted successfully');
        } catch (QueryException $e) {
            return back()->withErrors(['error' => 'User ini tidak dapat dihapus karena memiliki data terkait (Jadwal, Janji Temu, atau Rekam Medis). Silakan non-aktifkan akun atau hapus data terkait terlebih dahulu.']);
        }
    }
}