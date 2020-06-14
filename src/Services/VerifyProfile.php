<?php
namespace Joesama\Profile\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Hash;
use Joesama\Profile\Services\Traits\ModelTrait;
use Joesama\Profile\Services\Contracts\ProcessProfileContract;

/**
 * User profile verification services.
 *
 * 1. Verify profile data.
 */
class VerifyProfile extends AbstractProfile implements ProcessProfileContract
{
    protected $identity;

    /**
    * Initiate user profile verification service.
    *
    * @param string $uuid
    */
    public function __construct(string $uuid = null)
    {
        $this->identity = (new UserProfile($uuid))->info();
    }

    /**
     * Verify parameter passed.
     * Implementation should happend inherit class side.
     *
     * @param array $parameters
     *
     * @return bool
     */
    public function verify(array $parameters): bool
    {
        return Hash::check($parameters['key'], $this->identity->user->password);
    }

    /**
     * Get the validation errors.
     * Implementation should happend inherit class side.
     *
     * @return MessageBag
     */
    public function validationErrors(): MessageBag
    {
        return new MessageBag([
            'key' => __('profile::verification.validation.key')
        ]);
    }

    /**
     * Verifying user profile
     *
     * @param array $parameters
     *
     * @return void
     */
    public function verifyingProfile(array $parameters)
    {
        $newIdentity = config('profile.allow.import') ? null : Str::uuid();

        $this->updateIdentity($parameters, $newIdentity);

        return $this->updateProfile($parameters, $newIdentity);
    }

    /**
     * Update profile information.
     *
     * @param array $parameter
     * @param string $newIdentity
     *
     * @return Model
     */
    protected function updateProfile(array $parameter, string $newIdentity = null): Model
    {
        $profile = $this->identity;

        if ($newIdentity !== null) {
            $profile->user_id = $newIdentity;
        }

        $profile->activated_at = now();

        $profile->active = true;

        $profile->save();

        return $profile;
    }

    /**
     * Update user information.
     *
     * @param array $parameter
     * @param string $newIdentity
     *
     * @return void
     */
    protected function updateIdentity(array $parameter, string $newIdentity = null)
    {
        $user = $this->identity->user;

        if ($newIdentity !== null) {
            $user->{config('profile.user.uuid')} = $newIdentity;
        }

        $schema = $user->getConnection()->getSchemaBuilder();

        $tableName = $user->getTable();

        if (($schema->hasColumn($tableName, 'email_verified_at'))) {
            $user->email_verified_at = now();
        }

        if (($schema->hasColumn($tableName, 'username'))) {
            $user->username = $parameter['username'];
        }

        if (($schema->hasColumn($tableName, 'username'))) {
            $user->password = Hash::make($parameter['password']);
        }

        $user->save();
    }
}
