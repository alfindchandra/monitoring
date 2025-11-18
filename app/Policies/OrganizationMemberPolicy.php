<?php

namespace App\Policies;

use App\Models\OrganizationMember;
use App\Models\User;

class OrganizationMemberPolicy
{
    public function update(User $user, OrganizationMember $member): bool
    {
        return $user->ormawa_id === $member->ormawa_id || $user->isAdmin();
    }

    public function delete(User $user, OrganizationMember $member): bool
    {
        return $user->ormawa_id === $member->ormawa_id || $user->isAdmin();
    }
}