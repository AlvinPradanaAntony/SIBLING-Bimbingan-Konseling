<?php

namespace App\Http\Controllers;

use App\Models\Reports;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
    public function index()
    {
        return view('laporan',[
            'laporan' => Reports::all(),
            'active' => 'reports'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            // Tambahkan validasi sesuai kebutuhan
        ]);

        Reports::create([
            // Tambahkan field sesuai kebutuhan
        ]);
        return redirect()->route('reports.index')->with('success', 'Data baru berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang diterima dari form
        $request->validate([
            // Tambahkan validasi sesuai kebutuhan, misalnya untuk role
        ]);

        $user = Reports::findOrFail($id);
        $user->update([
            // Tambahkan field  yang akan diupdate
        ]);

        return redirect()->route('repoorts.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = Reports::findOrFail($id);
        $user->delete();
        return redirect()->route('reports.index')->with('success', 'Data berhasil dihapus.');
    }
}
