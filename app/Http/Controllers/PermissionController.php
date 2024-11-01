<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index()
    {
        return view('permission', [
            'permissions' => Permission::all(),
            'roles' => Role::all(),
            'active' => 'permission'
        ]);
    }

    public function update(Request $request, $roleId)
    {
        $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id', // Pastikan setiap permission ada
        ]);

        $role = Role::findOrFail($roleId);

        // Ambil nama-nama permission berdasarkan id
        $permissionNames = Permission::whereIn('id', $request->permissions)->pluck('name')->toArray();

        // Sinkronisasi permission berdasarkan nama
        $role->syncPermissions($permissionNames);

        return redirect()->route('permission.index')->with('success', 'Permissions updated successfully.');
    }

}
