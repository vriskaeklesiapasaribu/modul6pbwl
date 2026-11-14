<?php

namespace Database\Seeders;

use App\Models\Anggota;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $this->buat('admin@gmail.com', 'Administrator', 'admin', env('SEED_ADMIN_PASSWORD'));
        $this->buat('petugas@gmail.com', 'Petugas Perpustakaan', 'petugas', env('SEED_PETUGAS_PASSWORD'));
        $siswa1 = $this->buat('siswa@gmail.com', 'Siswa Teladan', 'siswa', env('SEED_SISWA_PASSWORD'));
        $siswa2 = $this->buat('siswa2@gmail.com', 'Siswa Kedua', 'siswa', env('SEED_SISWA_PASSWORD'));

        $anggotaIds = DB::table('peminjamans')->distinct()->pluck('anggota_id')->values();
        $this->hubungkan($siswa1, $anggotaIds[0] ?? null);
        $this->hubungkan($siswa2, $anggotaIds[1] ?? null);
    }

    private function buat(string $email, string $nama, string $role, ?string $password): User
    {
        // tanpa nilai di .env, password diacak sehingga tidak bisa ditebak
        $user = User::updateOrCreate(
            ['email' => $email],
            ['name' => $nama, 'password' => Hash::make($password ?: Str::random(24))]
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