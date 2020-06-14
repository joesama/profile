<?php

namespace Joesama\Profile\Events\Listeners;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Queue\InteractsWithQueue;
use Joesama\Profile\Events\ProfileSaved;
use Illuminate\Contracts\Queue\ShouldQueue;
use Joesama\Profile\Notifications\VerifyProfile as VerifyProfileNotification;

class VerifyProfile
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ProfileSaved $profile)
    {
        if (config('profile.verification') === true && $profile->creation === true) {
            $profile->profile->notify(
                new VerifyProfileNotification($profile->request)
            );
        }
    }
}
