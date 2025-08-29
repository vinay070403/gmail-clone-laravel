<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LoginController extends Controller
{
    // Show login form
    public function show(): View
    {
        return view('auth.login');
    }

    // Handle login
    public function login(LoginRequest $request): RedirectResponse
    {
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return back()->withInput()->withErrors([
                'email' => 'Invalid credentials provided.',
            ]);
        }

        // Use Laravel session auth
        Auth::login($user, $request->boolean('remember'));

        return redirect()->route('inbox')->with('success', 'Welcome back, ' . $user->name . '!');
    }
}
