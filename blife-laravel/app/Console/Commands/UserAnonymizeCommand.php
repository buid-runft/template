<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UserAnonymizeCommand extends Command
{
    protected $signature = 'user:anonymize {user_id}';
    protected $description = 'Anonymize user data for PDPA compliance';

    public function handle(): int
    {
        $userId = $this->argument('user_id');
        $user = User::find($userId);

        if (!$user) {
            $this->error('User not found');
            return 1;
        }

        DB::transaction(function () use ($user) {
            // ลบรูปโปรไฟล์
            if ($user->profile && $user->profile->profile_image) {
                $path = str_replace('/storage/', '', $user->profile->profile_image);
                \Storage::delete("public/{$path}");
            }

            // เขียนทับข้อมูลส่วนตัว
            $user->update([
                'email' => 'anonymized_' . $user->id . '@example.com',
                'phone' => null,
                'user_code' => 'ANONYMIZED_' . $user->user_code,
            ]);

            if ($user->profile) {
                $user->profile->update([
                    'first_name' => 'Anonymized',
                    'last_name' => 'User',
                    'address_line_1' => null,
                    'bank_account_number' => null, // ถ้าไม่ได้ encrypt ไว้ก่อน
                ]);
            }

            $this->info("User {$user->id} anonymized successfully");
        });

        return 0;
    }
}
