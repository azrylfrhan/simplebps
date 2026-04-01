<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AkunController extends Controller
{
    public function index() {
        $users = User::with('tim')->orderBy('id')->get();
        $tim = Tim::orderBy('nama_tim')->get();
        return view('akun.index', compact('users', 'tim'));
    }

    public function store(Request $request) {
        $request->validate([
            'username' => 'required|unique:users,username|max:50',
            'role' => 'required|in:admin,kabag,operator',
            'tim_id' => 'required_if:role,operator|nullable|exists:tim,id'
        ]);

        User::create([
            'username' => $request->username,
            'nama_lengkap' => $request->username,
            'password' => Hash::make('12345678'),
            'role' => $request->role,
            'tim_id' => $request->role === 'operator' ? $request->tim_id : null,
            'status' => 'aktif',
            'wajib_ganti_password' => 1
        ]);

        return back()->with('success', 'Akun berhasil dibuat dengan password default 12345678');
    }

    // AkunController.php
public function update(Request $request)
{
    $request->validate([
        'id' => 'required|exists:users,id',
        'username' => 'required|unique:users,username,' . $request->id,
        'role' => 'required|in:admin,kabag,operator',
        'tim_id' => 'required_if:role,operator|nullable|exists:tim,id'
    ]);

    $user = User::findOrFail($request->id);
    $user->username = $request->username;
    $user->role = $request->role;

    $user->tim_id = ($request->role === 'operator') ? $request->tim_id : null;

    $user->save();

    return back()->with('success', 'Data akun berhasil diperbarui.');
}

    public function resetPassword(Request $request) {
        $user = User::findOrFail($request->id);
        $user->update([
            'password' => Hash::make('12345678'),
            'wajib_ganti_password' => 1
        ]);
        return back()->with('success', 'Password berhasil direset ke 12345678');
    }

    public function ubahStatus(Request $request) {
        $user = User::findOrFail($request->id);
        $user->update(['status' => $request->status]);
        return back()->with('success', 'Status akun berhasil diubah');
    }
}
