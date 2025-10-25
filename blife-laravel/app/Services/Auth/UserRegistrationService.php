<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Models\UserProfile;
use App\Services\External\Contracts\MlmApiClientInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserRegistrationService
{
    public function __construct(
        protected MlmApiClientInterface $mlmApi
    ) {}

    public function register(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'uuid' => Str::uuid(),
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'phone' => $data['phone'] ?? null,
                'user_code' => $this->generateUserCode(),
                'mlm_member_code' => $data['mlm_member_code'] ?? null,
                'is_active' => true,
            ]);

            UserProfile::create([
                'user_id' => $user->id,
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'gender' => $data['gender'] ?? null,
                'date_of_birth' => $data['date_of_birth'] ?? null,
            ]);

            // Dispatch event เพื่อ verify MLM ต่อไป
            event(new \App\Events\UserRegistered($user));

            return $user;
        });
    }

    protected function generateUserCode(): string
    {
        do {
            $code = 'USR' . strtoupper(Str::random(8));
        } while (User::where('user_code', $code)->exists());

        return $code;
    }
}
