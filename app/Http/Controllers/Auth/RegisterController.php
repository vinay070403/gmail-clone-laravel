<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Throwable;

class RegisterController extends Controller
{
    // Show the registration form
    public function create(): View
    {
        return view('auth.register');
    }

    // Handle registration
    public function store(RegisterRequest $request): RedirectResponse
    {
        try {
            User::create([
                'name'     => $request->input('name'),
                'email'    => $request->input('email'),
                'password' => Hash::make($request->input('password')), // manual + explicit
            ]);

            // For now, send them to login screen with a flash message
            return redirect('/login')->with('success', 'Account created successfully. Please log in.');
        } catch (Throwable $e) {
            // (Optional) log error in real projects
            return back()->withInput()->withErrors([
                'general' => 'Something went wrong. Please try again.',
            ]);
        }
    }
}
