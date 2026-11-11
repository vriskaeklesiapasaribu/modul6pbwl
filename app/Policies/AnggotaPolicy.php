<?php

namespace App\Policies;

use App\Models\Anggota;
use App\Models\User;

class AnggotaPolicy
{
    public function view(User $user, Anggota $anggota): bool
    {
        if ($user->hasAnyRole(['admin', 'petugas'])) {
            return true;
        }

        return $anggota->user_id === $user->id;
    }
}