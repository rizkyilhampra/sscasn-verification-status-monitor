<?php

namespace App\Exceptions;

use App\Models\VerificationStatus;
use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Log;

class InvalidVerificationStatusResult extends Exception
{
    public function __construct(
        protected Response $response,
        protected VerificationStatus $verificationStatus,
        string $message
    ) {
        parent::__construct($message);
    }

    public function report()
    {
        Log::error($this->message, [
            'result' => $this->response->json(),
            'status' => $this->response->status(),
            'headers' => $this->response->headers(),
        ]);
    }
}
