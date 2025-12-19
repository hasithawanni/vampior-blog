<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

class SocialAuthController extends Controller
{
    /**
     * Set up a Guzzle client that ignores SSL verification errors for local dev.
     */
    protected function getHttpClient()
    {
        return new Client([
            'verify' => false, // This skips the SSL certificate check
            'timeout' => 20,
        ]);
    }

    // 1. Send user to GitHub/Google
    public function redirect($provider)
    {
        return Socialite::driver($provider)
            ->setHttpClient($this->getHttpClient())
            ->redirect();
    }

    // 2. Handle the return from GitHub/Google
    public function callback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)
                ->setHttpClient($this->getHttpClient())
                ->stateless()
                ->user();

            // Find user by Email OR Social ID
            $user = User::where('email', $socialUser->getEmail())
                ->orWhere($provider . '_id', $socialUser->getId())
                ->first();

            if ($user) {
                // Update existing user data
                $user->update([
                    $provider . '_id' => $socialUser->getId(),
                ]);
            } else {
                // Create new user
                $user = User::create([
                    'name' => $socialUser->getName() ?? $socialUser->getNickname(),
                    'email' => $socialUser->getEmail(),
                    'password' => Hash::make(Str::random(16)),
                    $provider . '_id' => $socialUser->getId(),
                ]);

                // 🛡️ ROLE ASSIGNMENT: Ensure 'reader' role exists before assigning
                if (\Spatie\Permission\Models\Role::where('name', 'reader')->exists()) {
                    $user->assignRole('reader');
                }
            }

            Auth::login($user);

            return redirect('/dashboard')->with('success', 'Successfully logged in with ' . ucfirst($provider));
        } catch (\Exception $e) {
            // If it still fails, this will show us the exact next error
            dd([
                'Message' => $e->getMessage(),
                'Line' => $e->getLine(),
                'File' => $e->getFile()
            ]);
        }
    }
}
