<?php
namespace App\Policies;

use App\Models\Division;
use App\Models\User;

class DivisionPolicy
{
    public function update(User $user, Division $division): bool
    {
        return $user->ormawa_id === $division->ormawa_id || $user->isAdmin();
    }

    public function delete(User $user, Division $division): bool
    {
        return $user->ormawa_id === $division->ormawa_id || $user->isAdmin();
    }
}
