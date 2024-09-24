<?php

namespace App\Http\Controllers;

use App\Models\Forms;
use Illuminate\Http\Request;

class FormsController extends Controller
{
    public function index()
    {
        return view('data_form',[
            'form' => Forms::all()
        ]);
    }

    
    public function store(Request $request)
    {
        $request->validate([
            // Tambahkan validasi sesuai kebutuhan
        ]);

        Forms::create([
            // Tambahkan field sesuai kebutuhan
        ]);
        return redirect()->route('form.index')->with('success', 'Data baru berhasil ditambahkan.');
    }


    public function edit($id)
    {
        $user = Forms::findOrFail($id);
        return view('form.edit', compact('form'));
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang diterima dari form
        $request->validate([
            // Tambahkan validasi sesuai kebutuhan, misalnya untuk role
        ]);

        $user = Forms::findOrFail($id);
        $user->update([
            // Tambahkan field  yang akan diupdate
        ]);

        return redirect()->route('form.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = Forms::findOrFail($id);
        $user->delete();
        return redirect()->route('form.index')->with('success', 'Data berhasil dihapus.');
    }
}
