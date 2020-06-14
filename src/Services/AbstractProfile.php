<?php
namespace Joesama\Profile\Services;

use Illuminate\Validation\Rule;
use Illuminate\Support\MessageBag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Joesama\Profile\Services\Traits\ModelTrait;

/**
 * Abstarct User profile verification services.
 */
class AbstractProfile
{
    use ModelTrait;

    /**
     * Validations rules.
     *
     * @var array
     */
    protected $validations = [];

    public function getProfileModel(): Model
    {
        $classModelName = config('profile.has.organization') ?
        config('profile.model.organization') :
        config('profile.model.default');

        return $this->model($classModelName);
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
        return true;
    }

    /**
     * Get the validation errors.
     * Implementation should happend inherit class side.
     *
     * @return MessageBag
     */
    public function validationErrors(): MessageBag
    {
        return new MessageBag([]);
    }
}
