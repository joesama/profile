<?php

namespace Joesama\Profile\Data\Model;

use Joesama\Profile\Data\Model\Profile;

class ProfileWithOrganization extends Profile
{
    /**
     * Get all of the department that are assigned this organization.
     */
    public function department()
    {
        return $this->morphedByMany(Department::class, 'organization', 'organization', 'profile_id');
    }

    /**
     * Get all of the unit that are assigned this organization.
     */
    public function unit()
    {
        return $this->morphedByMany(Unit::class, 'organization', 'organization', 'profile_id');
    }
}
