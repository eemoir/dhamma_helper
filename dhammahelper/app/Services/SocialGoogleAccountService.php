<?php

namespace App\Services;
use App\SocialGoogleAccount;
use App\User;
use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialGoogleAccountService
{
    public function createOrGetUser(ProviderUser $providerUser)
    {
        $account = SocialGoogleAccount::whereProvider('google')
            ->whereProviderUserId($providerUser->getId())
            ->first();

        if ($account) {
            return $account->user;
        } else {

            $account = new SocialGoogleAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider' => 'google'
            ]);

            $user = User::whereEmail($providerUser->getEmail())->first();

            if (!$user) {
                $full_name = $providerUser->getName();
                $split_name = explode(" ", $full_name);

                if (count($split_name) == 2) {
                    $first_name = $split_name[0];
                    $last_name = $split_name[1];
                } 

                else if (count($split_name) == 1) {
                    $first_name = $split_name[0];
                    $last_name = $first_name;
                }

                else {
                    $first_name = $split_name[0];
                    $last_name = $split_name[count($split_name)-1];
                }

                $exists = User::where('username', $first_name)->first();

                if (isset($exists)) {
                    while (isset($exists)) {
                        $rand = rand(1000, 9999);
                        $username = strtolower($first_name).$rand;
                        $exists = User::where('username', $username)->first();
                    }
                } else {
                    $username = $first_name;
                }

                $user = User::create([
                    'email' => $providerUser->getEmail(),
                    'full_name' => $full_name,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'username' => $username,
                    'password' => md5(rand(1,10000)),
                ]);
            }

            $account->user()->associate($user);
            $account->save();

            return $user;
        }
    }
}