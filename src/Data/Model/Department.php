<?php

namespace Joesama\Profile\Data\Model;

use Joesama\Profile\Data\Model\Unit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
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
     * The unit that belong to the department.
     */
    public function unit()
    {
        return $this->morphMany(
            Unit::class,
            'department',
            'department_type',
            'department_id'
        );
    }
}
