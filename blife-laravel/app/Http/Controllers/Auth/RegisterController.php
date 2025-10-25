<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\UserRegistrationService;
use App\Http\Requests\RegisterUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    protected $userRegistrationService;

    public function __construct(UserRegistrationService $userRegistrationService)
    {
        $this->userRegistrationService = $userRegistrationService;
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(RegisterUserRequest $request)
    {
        $user = $this->userRegistrationService->register($request->validated());

        // Log the user in
        Auth::login($user);

        return redirect()->route('home')->with('success', 'Registration successful!');
    }
}
