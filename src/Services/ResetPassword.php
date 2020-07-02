<?php
namespace Joesama\Profile\Services;

use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Joesama\Profile\Notifications\PasswordRequest;
use Joesama\Profile\Services\Traits\PasswordUpdater;
use Joesama\Profile\Services\Contracts\ProcessProfileContract;

/**
 * User profile reset password services.
 *
 * 1. Reset password.
 */
class ResetPassword extends AbstractProfile implements ProcessProfileContract
{
    use PasswordUpdater;

    protected $identity;

    /**
     * Profile parameter validations.
     *
     * @var Validator
     */
    private $validation;

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
     * Reset profile password.
     *
     * @param array $parameters
     *
     * @return void
     */
    public function resetProfilePassword(array $parameters)
    {
        $this->updateIdentityPassword($this->identity->user, $parameters['password']);

        return $this->identity;
    }
}
