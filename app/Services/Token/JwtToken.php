<?php

namespace App\Services\Token;
use App\Services\user;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtToken
{

    protected const KEY = 'test_jwt_key';
    public function __construct(protected string $jwtToken)
    {

    }

    public function getJwtToken() : string
    {
        return $this->jwtToken;
    }


    public function getUser() : user|null
    {
        $key = env('APP_KEY');
        $headers = new \stdClass();
        try {
            $decoded = JWT::decode($this->jwtToken, new Key($key, 'HS256'), $headers);
        } catch (\Exception $e) {
            return null;
        }
        if ($decoded->exp < \Illuminate\Support\Carbon::now()->timestamp) {
            return null;
        }
        $user = new user();
        $user->id = $decoded->user->id;
        $user->name = $decoded->user->name;
        $user->email = $decoded->user->email;
        $user->phone = $decoded->user->phone;
        return $user;
    }

}
