<?php
namespace Joesama\Profile\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Joesama\Profile\Events\ProfileSaved;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Joesama\Profile\Services\Traits\ModelTrait;

/**
 * User profile information services.
 *
 * 1. Save profile data.
 * 2. Retrieve profile by unique id.
 */
class UserProfile
{
    use ModelTrait;
    
    /**
     * Profile unique id.
     *
     * @var string
     */
    private $profileId;

    /**
     * Creation flag.
     *
     * @var bool
     */
    private $isCreation;

    /**
     * Profile parameter validations.
     *
     * @var Validator
     */
    private $validation;

    /**
     * Initiate user profile information service.
     *
     * @param string $uuid
     */
    public function __construct(string $uuid = null)
    {
        $this->isCreation = ($uuid === null) ? true: false;

        $this->profileId = $uuid ?? Str::uuid();
    }

    /**
     * Verify parameter passed.
     *
     * @param array $parameters
     *
     * @return bool
     */
    public function verify(array $parameters): bool
    {
        $this->validation = Validator::make($parameters, [
            'email' => [
                'required',
                Rule::unique('profiles')->ignore($parameters['uuid'], 'user_id'),
                'email:rfc,filter',
            ],
            'name' => 'required',
            'position' => 'required',
        ]);

        return !$this->validation->fails();
    }

    /**
     * Get the validation errors.
     *
     * @return MessageBag
     */
    public function validationErrors(): MessageBag
    {
        return $this->validation->errors();
    }

    /**
     * Get the profile model.
     *
     * @param array $parameters
     *
     * @return Model
     */
    public function profile(array $parameters): Model
    {
        $profileModel = config('profile.has.organization') ?
            config('profile.model.organization') :
            config('profile.model.default');

        $parameters[config('profile.user.uuid')] = $this->profileId;

        $profile = $this->model($profileModel)->updateOrCreate(
            [

                'user_type' => config('profile.user.model'),
                'user_id' => $this->profileId
            ],
            [
                'name' => Arr::get($parameters, 'name'),
                'email' => Arr::get($parameters, 'email')
            ]
        );

        $profile->save();

        event(new ProfileSaved($profile, $parameters, $this->isCreation));

        return $profile;
    }
}
