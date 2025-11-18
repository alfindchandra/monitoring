<?php

namespace App\Providers;

use App\Models\Announcement;
use App\Policies\AnnouncementPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{

protected $policies = [
     Announcement::class => AnnouncementPolicy::class,
    \App\Models\Announcement::class => \App\Policies\AnnouncementPolicy::class,
    \App\Models\Division::class => \App\Policies\DivisionPolicy::class,
    \App\Models\OrganizationMember::class => \App\Policies\OrganizationMemberPolicy::class,
];
    public function boot(): void
    {
        //
    }
}