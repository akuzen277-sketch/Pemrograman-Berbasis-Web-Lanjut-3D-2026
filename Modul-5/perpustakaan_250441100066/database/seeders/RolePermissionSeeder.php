<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]
            ->forgetCachedPermissions();

        // Mengubah role anggota menjadi siswa
        $anggota = Role::where('name', 'anggota')
            ->where('guard_name', 'web')
            ->first();

        $siswaSudahAda = Role::where('name', 'siswa')
            ->where('guard_name', 'web')
            ->exists();

        if ($anggota && $siswaSudahAda) {
            throw new \RuntimeException(
                'Role anggota dan siswa sama-sama sudah ada. Periksa data role terlebih dahulu.'
            );
        }

        if ($anggota && !$siswaSudahAda) {
            $anggota->update(['name' => 'siswa']);
        }

        // Membuat role
        $admin = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $petugas = Role::firstOrCreate([
            'name' => 'petugas',
            'guard_name' => 'web',
        ]);

        $siswa = Role::firstOrCreate([
            'name' => 'siswa',
            'guard_name' => 'web',
        ]);

        // Membuat 16 permission sesuai Modul 5
        $permissions = [
            'akses dashboard admin',
            'akses dashboard petugas',
            'view buku',
            'kelola data buku',
            'kelola data pengguna',
            'kelola role pengguna',
            'kelola peminjaman',
            'kelola pengembalian',
            'mengajukan peminjaman buku',
            'memproses persetujuan peminjaman',
            'mencatat pengembalian buku',
            'melihat status peminjaman sendiri',
            'melihat riwayat peminjaman sendiri',
            'lihat laporan perpustakaan',
            'lihat profil sendiri',
            'ubah profil sendiri',
        ];

        // Permission tambahan untuk kompatibilitas API lama
        $apiPermissions = [
            'create buku',
            'edit buku',
            'delete buku',
        ];

        foreach (array_merge($permissions, $apiPermissions) as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        // Hak akses Admin
        $admin->syncPermissions(
            array_merge($permissions, $apiPermissions)
        );

        // Hak akses Petugas
        $petugas->syncPermissions([
            'akses dashboard petugas',
            'view buku',
            'kelola data buku',
            'create buku',
            'edit buku',
            'delete buku',
            'kelola peminjaman',
            'kelola pengembalian',
            'memproses persetujuan peminjaman',
            'mencatat pengembalian buku',
            'lihat laporan perpustakaan',
            'lihat profil sendiri',
            'ubah profil sendiri',
        ]);

        // Hak akses Siswa
        $siswa->syncPermissions([
            'view buku',
            'mengajukan peminjaman buku',
            'melihat status peminjaman sendiri',
            'melihat riwayat peminjaman sendiri',
            'lihat profil sendiri',
            'ubah profil sendiri',
        ]);

        app()[PermissionRegistrar::class]
            ->forgetCachedPermissions();
    }
}
