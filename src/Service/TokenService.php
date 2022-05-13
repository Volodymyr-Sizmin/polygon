<?php

namespace App\Service;

use App\Entity\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class TokenService
{
    public function createToken(array $data)
    {
        $private_key = openssl_pkey_new();

        $public_key_pem = openssl_pkey_get_details($private_key)['key'];

        $public_key = openssl_pkey_get_public($public_key_pem);

        $jwt = JWT::encode($data, $private_key, 'RS256');
        $decoded = JWT::decode($jwt, new Key($public_key, 'RS256'));
    }

    public function fetchToken($user)
    {
        $token = $user->getToken();

        return $token;
    }
}
