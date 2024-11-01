<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'Lihat Siswa']);
        Permission::create(['name' => 'Tambah Siswa']);
        Permission::create(['name' => 'Ubah Siswa']);
        Permission::create(['name' => 'Hapus Siswa']);

        Permission::create(['name' => 'Lihat User']);
        Permission::create(['name' => 'Tambah User']);
        Permission::create(['name' => 'Ubah User']);
        Permission::create(['name' => 'Hapus User']);

        Permission::create(['name' => 'Lihat Jurusan']);
        Permission::create(['name' => 'Tambah Jurusan']);
        Permission::create(['name' => 'Ubah Jurusan']);
        Permission::create(['name' => 'Hapus Jurusan']);

        Permission::create(['name' => 'Lihat Kelas']);
        Permission::create(['name' => 'Tambah Kelas']);
        Permission::create(['name' => 'Ubah Kelas']);
        Permission::create(['name' => 'Hapus Kelas']);

        Permission::create(['name' => 'Lihat Role']);
        Permission::create(['name' => 'Tambah Role']);
        Permission::create(['name' => 'Ubah Role']);
        Permission::create(['name' => 'Hapus Role']);

        Permission::create(['name' => 'Lihat Status']);
        Permission::create(['name' => 'Tambah Status']);
        Permission::create(['name' => 'Ubah Status']);
        Permission::create(['name' => 'Hapus Status']);

        Permission::create(['name' => 'Lihat Asesmen']);
        Permission::create(['name' => 'Tambah Asesmen']);
        Permission::create(['name' => 'Ubah Asesmen']);
        Permission::create(['name' => 'Hapus Asesmen']);

        Permission::create(['name' => 'Lihat Bimbingan']);
        Permission::create(['name' => 'Tambah Bimbingan']);
        Permission::create(['name' => 'Ubah Bimbingan']);
        Permission::create(['name' => 'Hapus Bimbingan']);

        Permission::create(['name' => 'Lihat Kasus']);
        Permission::create(['name' => 'Tambah Kasus']);
        Permission::create(['name' => 'Ubah Kasus']);
        Permission::create(['name' => 'Hapus Kasus']);

        Permission::create(['name' => 'Lihat Absensi']);
        Permission::create(['name' => 'Tambah Absensi']);
        Permission::create(['name' => 'Ubah Absensi']);
        Permission::create(['name' => 'Hapus Absensi']);

        Permission::create(['name' => 'Lihat Loker']);
        Permission::create(['name' => 'Tambah Loker']);
        Permission::create(['name' => 'Ubah Loker']);
        Permission::create(['name' => 'Hapus Loker']);

        Permission::create(['name' => 'Lihat Prestasi']);
        Permission::create(['name' => 'Tambah Prestasi']);
        Permission::create(['name' => 'Ubah Prestasi']);
        Permission::create(['name' => 'Hapus Prestasi']);

        Permission::create(['name' => 'Lihat Asesmen Siswa']);
        Permission::create(['name' => 'Tambah Asesmen Siswa']);
        Permission::create(['name' => 'Ubah Asesmen Siswa']);
        Permission::create(['name' => 'Hapus Asesmen Siswa']);

        Permission::create(['name' => 'Lihat Laporan']);
        Permission::create(['name' => 'Tambah Laporan']);
        Permission::create(['name' => 'Ubah Laporan']);
        Permission::create(['name' => 'Hapus Laporan']);

        Permission::create(['name' => 'Lihat Autentifikasi']);
        Permission::create(['name' => 'Tambah Autentifikasi']);
        Permission::create(['name' => 'Ubah Autentifikasi']);
        Permission::create(['name' => 'Hapus Autentifikasi']);

        Permission::create(['name' => 'Lihat Perizinan']);
        Permission::create(['name' => 'Tambah Perizinan']);
        Permission::create(['name' => 'Ubah Perizinan']);
        Permission::create(['name' => 'Hapus Perizinan']);

        Role::create(['name' => 'Siswa']);
        Role::create(['name' => 'Wali Kelas']);
        Role::create(['name' => 'Guru BK']);
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Super Admin']);

        $role_super_admin = Role::findByName('Super Admin');
        $role_super_admin->givePermissionTo(Permission::all());

        $role_admin = Role::findByName('Admin');
        $role_admin->givePermissionTo(Permission::all());

        $role_guru_bk = Role::findByName('Guru BK');
        $role_guru_bk->givePermissionTo([
            'Lihat Siswa',
            'Tambah Siswa',
            'Ubah Siswa',
            'Hapus Siswa',
            'Lihat User',
            'Lihat Jurusan',
            'Lihat Kelas',
            'Lihat Role',
            'Lihat Status',
            'Lihat Asesmen',
            'Tambah Asesmen',
            'Ubah Asesmen',
            'Hapus Asesmen',
            'Lihat Bimbingan',
            'Tambah Bimbingan',
            'Ubah Bimbingan',
            'Hapus Bimbingan',
            'Lihat Kasus',
            'Tambah Kasus',
            'Ubah Kasus',
            'Hapus Kasus',
            'Lihat Absensi',
            'Tambah Absensi',
            'Ubah Absensi',
            'Hapus Absensi',
            'Lihat Loker',
            'Tambah Loker',
            'Ubah Loker',
            'Hapus Loker',
            'Lihat Prestasi',
            'Tambah Prestasi',
            'Ubah Prestasi',
            'Hapus Prestasi',
            'Lihat Asesmen Siswa',
            'Tambah Asesmen Siswa',
            'Ubah Asesmen Siswa',
            'Hapus Asesmen Siswa',
            'Lihat Laporan',
            'Tambah Laporan',
            'Ubah Laporan',
            'Hapus Laporan',
        ]);
        
        $role_wali_kelas = Role::findByName('Wali Kelas');
        $role_wali_kelas->givePermissionTo([
            'Lihat Siswa',
            'Lihat Asesmen',
            'Lihat Bimbingan',
            'Lihat Kasus',
            'Lihat Absensi',
            'Lihat Loker',
            'Lihat Prestasi',
            'Lihat Asesmen Siswa'
        ]);

        $role_siswa = Role::findByName('Siswa');
        $role_siswa->givePermissionTo([
            'Lihat Absensi',
            'Lihat Loker',
        ]);
    }
}
