<?php

namespace Joesama\Profile\Events\Listeners;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Queue\InteractsWithQueue;
use Joesama\Profile\Events\ProfileSaved;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserProfile
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ProfileSaved $profile)
    {
        $parameters = $profile->request;

        $detail['name'] =  $parameters['name'];

        if ($profile->creation) {
            $detail['password'] =  Hash::make($parameters['password'] ?? Str::random(8));
        }

        $model = ($profile->user)->updateOrCreate(
            [
                'guid' => $parameters['guid'],
                'email' => $parameters['email']
            ],
            $detail
        );
    }
}
