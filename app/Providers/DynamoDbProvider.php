<?php
/**
 * Created by PhpStorm.
 * User: timothyregulski
 * Date: 6/27/17
 * Time: 7:46 PM
 */

namespace App\Providers;


use App\Models\DynamoDbUser;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class DynamoDbProvider implements UserProvider
{
    public function retrieveById($identifier) {
        return DynamoDbUser::find($identifier);
    }


    public function retrieveByToken($identifier, $token) {
        return DynamoDbUser::where('id', $identifier)
            ->where('rememberToken', $token)
            ->first();
    }


    public function updateRememberToken(Authenticatable $user, $token) {
        $user->setRememberToken($token);
        $user->save();
    }


    public function retrieveByCredentials(array $credentials) {
        $username = $credentials['username'];
        $user = DynamoDbUser::where('username', $username)->first();
        return $user;

    }


    public function validateCredentials(Authenticatable $user, array $credentials) {
        $password = $credentials['password'];
        $password = hash('sha256', $password);

        return $user->password == $password;
    }


}