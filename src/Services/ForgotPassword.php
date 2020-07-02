<?php
namespace Joesama\Profile\Services;

use Illuminate\Support\Str;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Validator;
use Joesama\Profile\Notifications\PasswordRequest;
use Joesama\Profile\Services\Contracts\ProcessProfileContract;
use Joesama\Profile\Services\Traits\PasswordUpdater;

/**
 * User profile forgot password services.
 *
 * 1. Sent verification email.
 */
class ForgotPassword extends AbstractProfile implements ProcessProfileContract
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
        $this->identity = (new UserProfile($uuid))->email();
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
        $this->validation = Validator::make(
            $parameters,
            [
                'email' => [
                    'required',
                    'exists:profiles,email',
                    'email:rfc,filter',
                ],
                'key' => 'same:session-key'
            ],
            [
                'key' => 'Invalid session!!!'
            ]
        );

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
     * Sent forgot password request notification.
     *
     * @param array $parameters
     *
     * @return void
     */
    public function sentRequestNotification(array $parameters)
    {
        $parameters['key'] = Str::random(12);

        $this->identity->notify(
            new PasswordRequest($parameters)
        );

        $this->updateIdentityPassword($this->identity->user, $parameters['key']);

        return $this->identity;
    }
}
