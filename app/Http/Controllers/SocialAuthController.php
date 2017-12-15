<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SocialAccountService;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        $service = new SocialAccountService();
        $user = $service->createOrGetUser($provider);
        auth()->login($user);
        return redirect()->to('/');
    }
}
