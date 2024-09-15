<?php

namespace App\Exceptions;

use App\Models\UserRequestHeader;
use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Log;

class InvalidResponseProcessRequest extends Exception
{
    public function __construct(
        protected Response $response,
        protected UserRequestHeader $userRequestHeader,
        string $message
    ) {
        parent::__construct($message);
    }

    public function report()
    {
        Log::error($this->message, [
           'body' => $this->response->body(),
            'status' => $this->response->status(),
            'headers' => $this->response->headers(),
        ]);
    }
}
