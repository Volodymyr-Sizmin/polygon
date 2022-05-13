<?php

namespace App\Service;

use Firebase\JWT\JWT;

class TokenService
{
    public function createToken(array $data)
    {
        $private_key = openssl_pkey_new();

        $public_key_pem = openssl_pkey_get_details($private_key)['key'];

        $public_key = openssl_pkey_get_public($public_key_pem);

        $jwt = JWT::encode($data, $private_key, 'RS256');

        return $jwt;
    }

    public function fetchToken($user)
    {
        $token = $user->getToken();

        return $token;
    }
}
