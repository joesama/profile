<?php

namespace Joesama\Profile;

use Joesama\Profile\Events\ProfileSaved;
use Joesama\Profile\Events\Listeners\UserProfile;
use Joesama\Profile\Events\Listeners\VerifyProfile;
use Joesama\Profile\Events\Listeners\ProfileHasPosition;
use Joesama\Profile\Events\Listeners\ProfileHasOrganization;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;

class ProfileEventProvider extends EventServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        ProfileSaved::class => [
            UserProfile::class,
            VerifyProfile::class,
            ProfileHasPosition::class,
            ProfileHasOrganization::class
        ],
    ];
}
