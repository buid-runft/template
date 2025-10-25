<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Services\Auth\UserRegistrationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function __construct(
        protected UserRegistrationService $registrationService
    ) {}

    public function register(RegisterUserRequest $request): JsonResponse
    {
        $user = $this->registrationService->register($request->validated());

        return response()->json([
            'message' => 'ลงทะเบียนสำเร็จ',
            'user' => $user->load('profile'),
        ], 201);
    }

    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'email' => ['ข้อมูลเข้าสู่ระบบไม่ถูกต้อง'],
            ]);
        }

        $user = Auth::user();
        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'message' => 'เข้าสู่ระบบสำเร็จ',
            'user' => $user->load('profile'),
            'token' => $token,
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'ออกจากระบบสำเร็จ',
        ]);
    }
}
