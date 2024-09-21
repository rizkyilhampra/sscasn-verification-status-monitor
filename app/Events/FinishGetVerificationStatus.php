<?php

namespace App\Events;

use App\Models\VerificationStatus;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FinishGetVerificationStatus
{
    use Dispatchable,  SerializesModels;

    public function __construct(
        public VerificationStatus $verificationStatus,
        public $result
    ) {}
}
