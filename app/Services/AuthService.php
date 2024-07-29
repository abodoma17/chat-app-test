<?php

namespace App\Services;

use App\Mail\RegisterMail;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function authenticate($credentials): bool
    {
        return Auth::attempt($credentials, true);
    }

    public function register(array $credentials)
    {
        Mail::to($credentials['email'])->send(new RegisterMail());

        $credentials['password'] = Hash::make($credentials['password']);
        $user = $this->userRepository->createUser($credentials['email'], $credentials['password']);

        if(!$user)
        {
            return false;
        }

        Auth::login($user, true);
        return true;
    }

    public function logout()
    {
        Auth::logout();
    }
}
