<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function login(): Response
    {
        return response()->view('user.login', ['title' => 'Login']);
    }

    public function doLogin(Request $request): Response|RedirectResponse
    {
        $user = $request->input('user');
        $password = $request->input('password');

        if (empty($user) || empty($password)) {
            // return response()->view('user.login', ['title' => 'Login', 'error' => 'User and password are required']);
            return Redirect('/login')->with('error', 'User and password are required');
        }

        if ($this->userService->login($user, $password)) {
            $request->session()->put('user', $user);
            // return redirect('/');
            return Redirect('/todolist')->with('success', 'Login successfully');
        }

        // return response()->view('user.login', ['title' => 'Login', 'error' => 'Invalid user or password']);
        return Redirect('/login')->with('error', 'Invalid user or password');
    }

    public function doLogout(Request $request): RedirectResponse
    {
        $request->session()->forget('user');
        // return redirect('/');
        return Redirect('/login')->with('success', 'Logout successfully');
    }
}
