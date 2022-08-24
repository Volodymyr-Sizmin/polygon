<?php

namespace App\Service;

use Firebase\JWT\JWT;

class TokenService
{
    public function createToken($dataEmail, $dataCode)
    {

        $private_key = 'nZr4u7x!A%D*G-KaPdSgVkYp2s5v8y/B?E(H+MbQeThWmZq4t6w9z_C&F)J@NcRf';

        $now_seconds = time();
        $payload = [
            'iss' => 'admin@polybank.ru',
            'iat' => $now_seconds,
            'exp' => $now_seconds + (60),
            'aud' => $dataEmail,
            'code' => $dataCode,
        ];

        return JWT::encode($payload, $private_key, 'HS512');
    }

    public function fetchToken($user)
    {
        $token = $user->getToken();

        return $token;
    }
}
