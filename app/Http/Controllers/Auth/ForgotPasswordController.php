<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ForgotPasswordController extends Controller
{
    // Show forgot password form
    public function show(): View
    {
        return view('auth.forgot-password');
    }

    // Handle reset token generation
    public function sendToken(ForgotPasswordRequest $request): RedirectResponse
    {
        $user = User::where('email', $request->email)->firstOrFail();

        $token = Str::random(64);
        $expiry = Carbon::now()->addHour(); // token valid for 1 hour

        $user->update([
            'reset_token' => $token,
            'reset_token_expiry' => $expiry,
        ]);

        // For now, we display link on the next page instead of sending mail
        return redirect()->route('auth.password.request')
            ->with('reset_link', url("/reset-password/{$token}"));
    }
}
