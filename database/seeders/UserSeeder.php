<?php

namespace Database\Seeders;

use App\Models\Anggota;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $this->buat('admin@gmail.com', 'Administrator', 'admin');
        $this->buat('petugas@gmail.com', 'Petugas Perpustakaan', 'petugas');
        $siswa1 = $this->buat('siswa@gmail.com', 'Siswa Teladan', 'siswa');
        $siswa2 = $this->buat('siswa2@gmail.com', 'Siswa Kedua', 'siswa');

        // hubungkan tiap siswa dengan anggota berbeda yang punya peminjaman
        $anggotaIds = DB::table('peminjamans')->distinct()->pluck('anggota_id')->values();
        $this->hubungkan($siswa1, $anggotaIds[0] ?? null);
        $this->hubungkan($siswa2, $anggotaIds[1] ?? null);
    }

    private function buat(string $email, string $nama, string $role): User
    {
        $user = User::firstOrCreate(
            ['email' => $email],
            ['name' => $nama, 'password' => Hash::make('password')]
        );
        $user->forceFill(['email_verified_at' => now()])->save();
        $user->syncRoles([$role]);

        return $user;
    }

    private function hubungkan(User $user, $anggotaId): void
    {
        Anggota::where('user_id', $user->id)->update(['user_id' => null]);

        if ($anggotaId) {
            Anggota::where('id', $anggotaId)->update(['user_id' => $user->id]);
        }
    }
}