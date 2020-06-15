<?php

namespace Joesama\Profile\Events\Listeners;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Joesama\Profile\Data\Model\Position;
use Joesama\Profile\Events\ProfileSaved;

class ProfileHasPosition
{
    /**
     * Input name as define in parameter passed.
     */
    const FIELD = 'position';

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ProfileSaved $profile)
    {
        $parameters = $profile->request;

        if (Arr::exists($parameters, self::FIELD)) {
            if (($positionId = intval($parameters[self::FIELD])) === 0 && $parameters[self::FIELD] !== null) {
                $description = Str::title($parameters[self::FIELD]);
            
                $position = Position::firstOrNew(['description' => $description]);

                $position->save();

                $positionId = $position->id;
            }

            ($profile->profile)->update([self::FIELD => $positionId]);
        }
    }
}
