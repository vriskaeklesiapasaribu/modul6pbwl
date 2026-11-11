<?php

namespace App\Policies;

use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PeminjamanPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Peminjaman $peminjaman): bool
    {
        // Admin dan petugas boleh melihat semua data peminjaman
        if ($user->hasAnyRole(['admin', 'petugas'])) {
            return true;
        }

        // Siswa/anggota hanya boleh melihat peminjaman miliknya sendiri
        return $user->anggota !== null
            && $user->anggota->id === $peminjaman->anggota_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Peminjaman $peminjaman): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Peminjaman $peminjaman): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Peminjaman $peminjaman): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Peminjaman $peminjaman): bool
    {
        return false;
    }
}