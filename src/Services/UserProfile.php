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
    private $profileIdentification;

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
     * Model class name use by application.
     *
     * @var string
     */
    private $profileModel;

    /**
     * Initiate user profile information service.
     *
     * @param string $uuid
     */
    public function __construct(string $uuid = null)
    {
        $this->isCreation = ($uuid === null) ? true: false;
        
        $this->profileIdentification = $uuid ?? Str::uuid();

        $this->profileModel = config('profile.has.organization') ?
        config('profile.model.organization') :
        config('profile.model.default');
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
                Rule::unique('profiles')->ignore($this->profileIdentification, 'user_id'),
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
        $parameters[config('profile.user.uuid')] = $parameters['uuid'] = $this->profileIdentification;

        $updateParams =             [
            'name' => Arr::get($parameters, 'name'),
            'email' => Arr::get($parameters, 'email'),
            'active' => Arr::get($parameters, 'active', false)
        ];

        $profile = $this->model($this->profileModel)->updateOrCreate(
            [

                'user_type' => config('profile.user.model'),
                'user_id' => $this->profileIdentification
            ],
            $updateParams
        );

        $profile->save();

        event(new ProfileSaved($profile, $parameters, Arr::get($parameters, 'verify', $this->isCreation)));

        return $profile;
    }

    /**
     * Get profile model.
     *
     * @return Model|null
     */
    public function info(): ?Model
    {
        return $this->model($this->profileModel)->where('user_id', $this->profileIdentification)->first();
    }

    /**
     * Get profile model by email.
     *
     * @return Model|null
     */
    public function email(): ?Model
    {
        return $this->model($this->profileModel)->where('email', $this->profileIdentification)->first();
    }
}
