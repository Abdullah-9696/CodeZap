<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SocialController extends Controller
{
    // Google

public function redirectToGoogle() {
    return Socialite::driver('google')->redirect();
}

public function handleGoogleCallback() {
    $socialUser = Socialite::driver('google')->user();
    return $this->loginOrCreateUser($socialUser, 'google');
}

    // Facebook
    public function redirectToFacebook() {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback() {
        $socialUser = Socialite::driver('facebook')->stateless()->user();
        return $this->loginOrCreateUser($socialUser, 'facebook');
    }

    // Twitter
    public function redirectToTwitter() {
        return Socialite::driver('twitter')->redirect();
    }

    public function handleTwitterCallback() {
        $socialUser = Socialite::driver('twitter')->stateless()->user();
        return $this->loginOrCreateUser($socialUser, 'twitter');
    }

    // Common function to login or create user
    protected function loginOrCreateUser($socialUser, $provider) {
        $user = User::firstOrCreate(
            ['email' => $socialUser->getEmail()],
            [
                'name' => $socialUser->getName(),
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
                'password' => bcrypt('socialpassword') // temporary
            ]
        );

        Auth::login($user, true);
        return redirect()->route('admin.dashboard'); // Change as needed
    }
}
