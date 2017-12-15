<?php

namespace App;

use Laravel\Socialite\Contracts\User as ProviderUser;
use Laravel\Socialite\Facades\Socialite;
class SocialAccountService
{
    public function createOrGetUser($provider)
    {
        $providerUser = Socialite::driver($provider)->user();
        $account = SocialAccount::whereProvider($provider)
            ->whereProviderUserId($providerUser->getId())
            ->first();

        if ($account) {
            return $account->user;
        } else {

            $account = new SocialAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider' => $provider
            ]);

            $user = User::whereEmail($providerUser->getEmail())->first();

            if (!$user) {

                $login = $providerUser->getNickname();
                if($login == ''){
                    $parts = explode("@", $providerUser->getEmail());
                    $loginNative = $login = $parts[0];

                    $counter = 1;
                    while (User::whereLogin($login)->first()){
                        $login = $loginNative."_".$counter;
                        $counter++;
                    }
                }

                $userData = [
                    'email' => $providerUser->getEmail(),
                    'first_name' => $providerUser->getName(),
                    'login' => $login,
                    'password' => bcrypt(random_bytes(10)),
                ];

                $userNameData = explode(' ', $providerUser->getName());
                if(count($userNameData) > 1){
                    $userData['first_name'] = $userNameData[1];
                    $userData['second_name'] = $userNameData[0];
                }

                $user = User::create($userData);
            }

            $account->user()->associate($user);
            $account->save();

            return $user;
        }

    }
}