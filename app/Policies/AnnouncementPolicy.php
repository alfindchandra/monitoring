<?php

namespace App\Policies;

use App\Models\Announcement;
use App\Models\User;

class AnnouncementPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Announcement $announcement): bool
    {
        // Admin can view all
        if ($user->isAdmin()) {
            return true;
        }
        
        // Owner can view
        if ($announcement->ormawa_id === $user->ormawa_id) {
            return true;
        }
        
        // Recipient can view
        return $announcement->recipients()->where('ormawas.id', $user->ormawa_id)->exists();
    }

    public function create(User $user): bool
    {
        return $user->isKetuaBem() || $user->isKetuaUkm();
    }

    public function update(User $user, Announcement $announcement): bool
    {
        return $announcement->ormawa_id === $user->ormawa_id;
    }

    public function delete(User $user, Announcement $announcement): bool
    {
        return $announcement->ormawa_id === $user->ormawa_id || $user->isAdmin();
    }
}