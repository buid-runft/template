<?php

namespace App\Http\Requests;

use App\Rules\ValidateMlmMemberCode;
use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|in:male,female,other',
            'date_of_birth' => 'nullable|date',
            'mlm_member_code' => ['nullable', 'string', new ValidateMlmMemberCode(app(\App\Services\External\Contracts\MlmApiClientInterface::class))],
        ];
    }

    public function messages(): array
    {
        return [
            'mlm_member_code.exists' => 'MLM Member Code ไม่ถูกต้องหรือไม่ได้ลงทะเบียนในระบบ',
        ];
    }
}
