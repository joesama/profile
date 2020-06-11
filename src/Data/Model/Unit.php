<?php

namespace Joesama\Profile\Data\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use SoftDeletes;
    
    protected $guarded = ['id'];
    /**
     * Get all of the profile for the .
     */
    public function profile()
    {
        return $this->morphToMany(ProfileWithOrganization::class, 'organization');
    }

    /**
     * The department that belong to the unit.
     */
    public function department()
    {
        return $this->morphTo('department', 'department_type', 'department_id');
    }
}
