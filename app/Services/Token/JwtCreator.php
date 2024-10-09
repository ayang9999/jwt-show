<?php

namespace App\Services\Token;
use App\Services\user;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtCreator
{


    static public function createByUser(user $user) : JwtToken
    {
        $key = env('APP_KEY');
        $user = (array)$user;
        unset($user['password']);
        $payload = [
            'iat' => $iat =\Illuminate\Support\Carbon::now()->timestamp, // 当前时间戳
            'exp' => $iat + 3600 * 24, // 令牌过期时间
            'user' => $user
        ];
        $jwt = JWT::encode($payload, $key, 'HS256');
        return new JwtToken($jwt);
    }


}
