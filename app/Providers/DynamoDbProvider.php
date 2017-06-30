<?php
/**
 * Created by PhpStorm.
 * Date: 6/27/17
 * Time: 7:46 PM
 */

namespace App\Providers;


use App\Models\DynamoDbUser;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Log;

class DynamoDbProvider implements UserProvider
{
    public function retrieveById($identifier) {

        Log::info('id: ' . $identifier);
        return DynamoDbUser::find($identifier);
    }


    public function retrieveByToken($identifier, $token) {
        Log::info('retrieveByToken');
        return DynamoDbUser::where('id', $identifier)
            ->where('rememberToken', $token)
            ->first();
    }


    public function updateRememberToken(Authenticatable $user, $token) {
        Log::info('updateRememberToken');
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
        Log::info($user->password == $password);
        return $user->password == $password;
    }


}
