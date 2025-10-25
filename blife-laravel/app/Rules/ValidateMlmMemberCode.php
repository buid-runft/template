<?php

namespace App\Rules;

use App\Services\External\Contracts\MlmApiClientInterface;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidateMlmMemberCode implements ValidationRule
{
    public function __construct(
        protected MlmApiClientInterface $mlmApi
    ) {}

    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (empty($value)) {
            return; // Allow empty values as it's nullable
        }

        try {
            $response = $this->mlmApi->verifyMember($value);
            $isValid = $response['valid'] ?? false;

            if (!$isValid) {
                $fail('MLM Member Code ไม่ถูกต้องหรือไม่ได้ลงทะเบียนในระบบ MLM');
            }
        } catch (\Exception $e) {
            $fail('ไม่สามารถตรวจสอบ MLM Member Code ได้ในขณะนี้ กรุณาลองใหม่อีกครั้ง');
        }
    }
}
