<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class PorkbunApiRequestFailedException extends Exception
{
    public function __construct(
        public readonly int $status_code,
        public readonly ?string $response = null
    )
    {
        parent::__construct("Porkbun API request failed with status code {$status_code}.");
    }

    /**
     * Report the exception.
     */
    public function report(): void
    {
        Log::error('Porkbun API request failed', [
            'status_code' => $this->status_code,
            'response' => $this->response ?? 'n/a'
        ]);
    }
}
