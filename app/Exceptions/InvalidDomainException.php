<?php

namespace App\Exceptions;

use Exception;

class InvalidDomainException extends Exception
{
    public function __construct(
        public readonly string $domain
    )
    {
        parent::__construct("Domain \"{$domain}\" is invalid.");
    }

    /**
     * Report the exception.
     */
    public function report(): bool
    {
        return false; // Eh, don't report :)
    }
}
