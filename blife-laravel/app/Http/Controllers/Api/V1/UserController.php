<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function profile(): JsonResponse
    {
        $user = auth()->user();
        return response()->json(new UserResource($user->load('profile')));
    }

    public function updateProfile(\App\Http\Requests\UpdateUserProfileRequest $request): JsonResponse
    {
        $user = auth()->user();
        $user->profile->update($request->validated());

        return response()->json(new UserResource($user->load('profile')));
    }
}
