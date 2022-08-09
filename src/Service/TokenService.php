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

        $now_seconds = time();
        $payload = array(
            "iss" => $data,
            "iat" => $now_seconds,
            "exp" => $now_seconds+(60)
        );
        return JWT::encode($payload, $private_key, "RS256");

        //$jwt = JWT::encode($data, $private_key, 'RS256');

        //return $jwt;
    }

    public function fetchToken($user)
    {
        $token = $user->getToken();

        return $token;
    }
}
