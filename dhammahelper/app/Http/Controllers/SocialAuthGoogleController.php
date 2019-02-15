<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use App\Services\SocialGoogleAccountService;

class SocialAuthGoogleController extends Controller
{
    public function googleRedirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function google(SocialGoogleAccountService $service) {
        $user = $service->createOrGetUser(Socialite::driver('google')->stateless()->user());
        auth()->login($user);
        return redirect()->to('/home');
    }

}
