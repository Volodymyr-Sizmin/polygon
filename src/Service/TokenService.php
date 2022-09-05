<?php

namespace App\Service;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class TokenService
{
    public function createToken(...$params)
    {
        $private_key = 'nZr4u7x!A%D*G-KaPdSgVkYp2s5v8y/B?E(H+MbQeThWmZq4t6w9z_C&F)J@NcRf';
        $array = [

        ];
        $now_seconds = time();
        $payload = [
            'iss' => 'admin@polybank.ru',
            'iat' => $now_seconds,
            'exp' => $now_seconds + (600),
            'aud' => 'your email',
            'params' => $params
        ];

        return JWT::encode($payload, $private_key, 'HS512');
    }

    public function decodeToken($token)
    {
        $private_key = 'nZr4u7x!A%D*G-KaPdSgVkYp2s5v8y/B?E(H+MbQeThWmZq4t6w9z_C&F)J@NcRf';
        return JWT::decode($token, new Key($private_key, 'HS512'));
    }

    public function fetchToken($user)
    {
        $token = $user->getToken();

        return $token;
    }
}
