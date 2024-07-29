<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthPostRequest;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login()
    {
        return view('auth/login');
    }

    public function register()
    {
        return view('auth/register');

    }

    public function doLogin(AuthPostRequest $request)
    {
        $credentials = [
            'email' => $request->get('email'),
            'password' => $request->get('password')
        ];

        $isAuthenticated = $this->authService->authenticate($credentials);

        if(!$isAuthenticated)
        {
            return redirect()->back()->with([
                'message' => 'Invalid credentials.',
                'alert-type' => 'error'
            ]);
        }

        return redirect()->intended(route('index'));
    }

    public function doRegister(AuthPostRequest $request)
    {
        $credentials = [
            'email' => $request->get('email'),
            'password' => $request->get('password')
        ];

        $isAuthenticated = $this->authService->register($credentials);

        if(!$isAuthenticated)
        {
            return redirect()->back()->with([
                'message' => 'An error has occured.',
                'alert-type' => 'error'
            ]);
        }

        return redirect()->intended(route('index'));
    }

    public function logout()
    {
        $this->authService->logout();

        return redirect(route('login'));
    }
}
