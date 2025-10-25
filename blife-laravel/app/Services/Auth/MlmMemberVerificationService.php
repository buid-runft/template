<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Services\External\Contracts\MlmApiClientInterface;

class MlmMemberVerificationService
{
    public function __construct(
        protected MlmApiClientInterface $mlmApi
    ) {}

    public function verifyUserMlmStatus(User $user): bool
    {
        if (!$user->mlm_member_code) {
            return false;
        }

        try {
            $response = $this->mlmApi->verifyMember($user->mlm_member_code);
            $isValid = $response['valid'] ?? false;

            if ($isValid) {
                // ถ้า valid → บันทึกใน database ด้วย
                $user->update(['is_active' => true]);
            }

            return $isValid;
        } catch (\Exception $e) {
            \Log::error('MLM Verification Failed', [
                'user_id' => $user->id,
                'mlm_code' => $user->mlm_member_code,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }
}
