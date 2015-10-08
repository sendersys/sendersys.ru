<?php

namespace App\Repositories;

use App\User;

class UserRepository {

    public function findByUserNameOrCreate($userData) {
    	// dd($userData);
        $user = User::where('provider_id', '=', $userData->id)->first();

        if(!$user) {
            $user = User::create([
                'provider_id' => $userData->id,
                'name' => $userData->name,
                'provider_nickname' => $userData->nickname,
                'email' => $userData->email,
                'avatar' => $userData->avatar,
            ]);
        }

        $this->checkIfUserNeedsUpdating($userData, $user);
        return $user;
    }

    public function checkIfUserNeedsUpdating($userData, $user) {

        $socialData = [
            'avatar' => $userData->avatar,
            'email' => $userData->email,
            'name' => $userData->name,
            'provider_nickname' => $userData->nickname,
        ];
        $dbData = [
            'avatar' => $user->avatar,
            'email' => $user->email,
            'name' => $user->name,
            'provider_nickname' => $user->username,
        ];

        if (!empty(array_diff($socialData, $dbData))) {
        	$user->provider_id = $userData->id;
            $user->avatar = $userData->avatar;
            $user->email = $userData->email;
            $user->name = $userData->name;
            $user->provider_nickname = $userData->nickname;
            $user->save();
        }
    }
}