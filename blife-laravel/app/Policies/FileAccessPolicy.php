<?php

namespace App\Policies;

use App\Models\User;
use App\Models\File;
use Illuminate\Auth\Access\HandlesAuthorization;

class FileAccessPolicy
{
    use HandlesAuthorization;

    public function view(User $user, File $file): bool
    {
        // ผู้สร้างไฟล์, เจ้าของ store/product, หรือ admin เท่านั้น
        return $this->isOwner($user, $file) || $user->hasRole('admin');
    }

    public function delete(User $user, File $file): bool
    {
        return $this->isOwner($user, $file) || $user->hasRole('admin');
    }

    protected function isOwner(User $user, File $file): bool
    {
        // ถ้าไฟล์เกี่ยวข้องกับ user
        if ($file->user_id === $user->id) {
            return true;
        }

        // ถ้าไฟล์เกี่ยวข้องกับ store ที่ user เป็นเจ้าของ
        if ($file->related_type === \App\Models\Store::class) {
            $store = $file->related;
            return $store && $store->user_id === $user->id;
        }

        // ถ้าไฟล์เกี่ยวข้องกับ product ที่ user เป็นเจ้าของ store
        if ($file->related_type === \App\Models\Product::class) {
            $product = $file->related;
            return $product && $product->store && $product->store->user_id === $user->id;
        }

        return false;
    }
}
