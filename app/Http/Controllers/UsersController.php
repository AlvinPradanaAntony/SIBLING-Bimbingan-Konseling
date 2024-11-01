<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
	public function __construct()
	{
			$this->middleware(['auth', 'verified']);
	}
	public function index()
	{
		return view('data_user', [
			'users' => User::with('role')->get(),
			'roles' => Role::all(),
			'active' => 'user'
		]);
	}

	public function store(Request $request)
	{
		// Validasi data yang diterima
		$request->validate([
			'name' => 'required|string|max:255',
			'email' => 'required|email|unique:users,email',
			'password' => 'required|string|min:8',
			'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
		]);

		// Buat user baru
		User::create([
			'name' => $request->name,
			'email' => $request->email,
			'password' => bcrypt($request->password),
			'photo' => $request->file('photo')->store('photos', 'public'),
			// Tambahkan field lainnya sesuai kebutuhan
		]);

		// Redirect ke halaman daftar pengguna dengan pesan sukses
		return redirect()->route('user.index')->with('success', 'Pengguna baru berhasil ditambahkan.');
	}

	public function update(Request $request, $id)
	{
		$request->validate([
			'nip' => 'required|string|max:255',
			'name' => 'required|string|max:255',
			'gender' => 'required|string|max:255',
			'place_of_birth' => 'required|string|max:255',
			'date_of_birth' => 'required|date',
			'religion' => 'required|string|max:255',
			'phone_number' => 'required|string|max:255',
			'address' => 'required|string|max:255',
			'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
			'email' => 'required|email',
		]);

		$user = User::findOrFail($id);

		$user->nip = $request->input('nip');
		$user->name = $request->input('name');
		$user->gender = $request->input('gender');
		$user->place_of_birth = $request->input('place_of_birth');
		$user->date_of_birth = $request->input('date_of_birth');
		$user->religion = $request->input('religion');
		$user->phone_number = $request->input('phone_number');
		$user->address = $request->input('address');
		if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete('user_photos/' . $user->photo);
            }
            $file = $request->file('photo');
            $path = $file->store('user_photos', 'public');
            $user->photo = basename($path);
        }
		$user->email = $request->input('email');
		$user->save();
		return redirect()->route('user.index')->with('success', 'Data pengguna berhasil diperbarui.');
	}

	public function destroy($id)
	{
		$user = User::findOrFail($id);
		$user->delete();
		return redirect()->route('user.index')->with('success', 'Pengguna berhasil dihapus.');
	}
}
