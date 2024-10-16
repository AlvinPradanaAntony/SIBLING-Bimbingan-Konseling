<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;

class StatusController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
    // Menampilkan semua status
    public function index()
    {
        return view('data_status', [
            'statuses' => Status::all(),
            'active' => 'status'
        ]);
    }

    // Menampilkan form untuk menambahkan status
    public function store(Request $request)
    {
        $request->validate([
            'status_name' => 'required|string|max:255',
        ]);

        $status = new Status();
        $status->status_name = $request->input('status_name');
        $status->save();

        return redirect()->route('status.index')->with('success', 'Status berhasil ditambahkan!');
    }

    // Menyimpan perubahan status ke database
    public function update(Request $request, $id)
    {
        $request->validate([
            'status_name' => 'required|string|max:255',
        ]);

        $status = Status::findOrFail($id);
        $status->status_name = $request->input('status_name');
        $status->save();

        return redirect()->route('status.index', $status->id)->with('success', 'Status berhasil diupdate!');
    }

    // Fungsi untuk menghapus status
    public function destroy($id)
    {
        $status = Status::findOrFail($id);
        $status->delete();

        // Redirect atau menampilkan pesan sukses
        return redirect()->route('status.index')->with('success', 'Status berhasil dihapus!');
    }
}
