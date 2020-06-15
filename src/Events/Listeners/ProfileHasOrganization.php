<?php

namespace Joesama\Profile\Events\Listeners;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Joesama\Profile\Data\Model\Unit;
use Joesama\Profile\Events\ProfileSaved;
use Joesama\Profile\Data\Model\Department;
use Joesama\Profile\Data\Model\Organization;

class ProfileHasOrganization
{
    /**
    * Input name as define in parameter passed.
    */
    const DEPARTMENT = 'department';

    /**
    * Input name as define in parameter passed.
    */
    const UNIT = 'unit';

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ProfileSaved $profile)
    {
        $parameters = $profile->request;

        if (config('profile.has.organization')) {
            if (Arr::exists($parameters, self::DEPARTMENT)) {
                $deptParam = $parameters[self::DEPARTMENT];

                $profile->profile->department()->detach();

                if (($departmentId = intval($deptParam)) === 0 && $deptParam !== null) {
                    $department = Department::firstOrNew(['description' => Str::title($deptParam)]);

                    $department->save();

                    $departmentId = $department->id;
                }

                $this->attachOrganization($profile->profile->id, $departmentId, Department::class);
            }

            if (Arr::exists($parameters, self::UNIT)) {
                $unitParam = $parameters[self::UNIT];
            
                $profile->profile->unit()->detach();

                if (($unitId = intval($unitParam)) === 0 && $unitParam !== null) {
                    $unit = Unit::firstOrNew(['description' => Str::title($unitParam)]);
                    
                    if (Arr::exists($parameters, self::DEPARTMENT)) {
                        $unit->department_type = Department::class;

                        $unit->department_id = $departmentId;
                    }

                    $unit->save();

                    $unitId = $unit->id;
                }

                $this->attachOrganization($profile->profile->id, $unitId, Unit::class);
            }
        }
    }

    /**
     * Attach organization data to profile.
     *
     * @param int $profileId
     * @param int $orgId
     * @param string $orgType
     *
     * @return void
     */
    protected function attachOrganization(int $profileId, int $orgId, string $orgType)
    {
        $attachDepartment = new Organization();

        $attachDepartment->organization_type = $orgType;

        $attachDepartment->organization_id = $orgId;

        $attachDepartment->profile_id = $profileId;

        $attachDepartment->save();
    }
}
