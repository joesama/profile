<?php
namespace Joesama\Profile\Data\Traits;

use Joesama\Profile\Data\Model\Profile;

trait WithUserProfile
{
    public function profile()
    {
        $profileClass = config('profile.has.organization') ?
        config('profile.model.organization') :
        config('profile.model.default');

        return $this->morphOne(
            $profileClass,
            'user',
            'user_type',
            'user_id',
            config('profile.user.uuid')
        );
    }
}
