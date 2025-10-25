<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Services\Auth\MlmMemberVerificationService;

class VerifyMlmMemberListener
{
    public function __construct(
        protected MlmMemberVerificationService $verificationService
    ) {}

    public function handle(UserRegistered $event): void
    {
        $this->verificationService->verifyUserMlmStatus($event->user);
    }
}
