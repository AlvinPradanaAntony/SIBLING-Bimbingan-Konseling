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

	public function settings()
	{
		return view('settings', [
			'users' => User::with('role')->get(),
			'roles' => Role::all(),
			'active' => 'settings'
		]);
	}

	public function showImage($id)
    {
        $user = User::findOrFail($id);
        if ($user->photo) {
            return response($user->photo)
                ->header('Content-Type', 'image/jpeg');
        }
        abort(404, 'Gambar tidak ditemukan.');
    }
    public function download($id)
    {
        $user = User::findOrFail($id);
        if ($user->photo) {
            $fileContent = $user->photo;
            $extension = $this->getFileExtension($user->photo);
            $fileName = "foto_siswa_{$user->id}.{$extension}";
            $contentType = $this->getContentTypeByExtension($extension);
            return response($fileContent)
                ->header('Content-Type', $contentType)
                ->header('Content-Disposition', "attachment; filename={$fileName}");
        }
        return redirect()->back()->with('error', 'Foto tidak ditemukan.');
    }
    private function getFileExtension($blob)
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_buffer($finfo, $blob);
        finfo_close($finfo);
        switch ($mimeType) {
            case 'application/pdf':
                return 'pdf';
            case 'image/jpeg':
                return 'jpg';
            case 'image/png':
                return 'png';
            case 'image/gif':
                return 'gif';
            default:
                return 'bin'; 
        }
    }
    private function getContentTypeByExtension($extension)
    {
        $mimeTypes = [
            'pdf' => 'application/pdf',
            'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'bin' => 'application/octet-stream', 
        ];
        return $mimeTypes[$extension] ?? 'application/octet-stream';
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
			'photo' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
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
            $fileContent = file_get_contents($request->file('photo')->getRealPath());
            $user->photo = $fileContent; 
        }
		$user->email = $request->input('email');
		$user->save();
		return redirect()->route('user.index')->with('success', 'Data pengguna berhasil diperbarui.');
	}

	public function setting_account(Request $request, $id)
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
			'photo' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
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
            $fileContent = file_get_contents($request->file('photo')->getRealPath());
            $user->photo = $fileContent; 
        }
		$user->email = $request->input('email');
		$user->save();
		return redirect()->route('user.settings')->with('success', 'Data pengguna berhasil diperbarui.');
	}

	public function destroy($id)
	{
		$user = User::findOrFail($id);
		$user->delete();
		return redirect()->route('user.index')->with('success', 'Pengguna berhasil dihapus.');
	}
}
