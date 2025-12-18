<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SocialAuthController extends Controller
{
    // 1. Send user to GitHub/Google
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    // 2. Handle the return from GitHub/Google
    public function callback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();

            // Find user by Email OR Social ID
            $user = User::where('email', $socialUser->getEmail())
                ->orWhere($provider . '_id', $socialUser->getId())
                ->first();

            if ($user) {
                // Update existing user data
                $user->update([
                    $provider . '_id' => $socialUser->getId(),
                    $provider . '_token' => $socialUser->token,
                ]);
            } else {
                // Create new user
                $user = User::create([
                    'name' => $socialUser->getName() ?? $socialUser->getNickname(),
                    'email' => $socialUser->getEmail(),
                    'password' => Hash::make(Str::random(16)),
                    $provider . '_id' => $socialUser->getId(),
                    $provider . '_token' => $socialUser->token,
                ]);

                // 🛡️ ROLE ASSIGNMENT: New social users must be Readers
                $user->assignRole('reader');
            }

            Auth::login($user);

            return redirect('/dashboard')->with('success', 'Successfully logged in with ' . ucfirst($provider));
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Login failed: ' . $e->getMessage());
        }
    }
}
