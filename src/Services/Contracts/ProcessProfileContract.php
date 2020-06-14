<?php
namespace Joesama\Profile\Services\Contracts;

use Illuminate\Support\MessageBag;

interface ProcessProfileContract
{
    /**
     * Verify parameter passed.
     * Implementation should happend inherit class side.
     *
     * @param array $parameters
     *
     * @return bool
     */
    public function verify(array $parameters): bool;

    /**
     * Get the validation errors.
     * Implementation should happend inherit class side.
     *
     * @return MessageBag
     */
    public function validationErrors(): MessageBag;
}
