<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function index()
    {
        return view('autentifikasi', [
            'users' => User::all(),
            'roles' => Role::all(),
            'active' => 'autentifikasi'
        ]);
    }
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/home');
        }
        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ]);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|string|exists:roles,name'
        ]);
        $user = User::findOrFail($id);
        $role = Role::where('name', $request->input('role'))->first();
        if ($role) {
            $user->syncRoles([$role->name]);
        }
        return redirect()->route('autentifikasi.index')->with('success', 'Data pengguna berhasil diperbarui');
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->roles()->detach();
        return redirect()->route('autentifikasi.index')->with('success', 'Role pengguna berhasil dihapus');
    }
}
