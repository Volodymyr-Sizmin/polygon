<?php

namespace App\Service;

use Firebase\JWT\JWT;

class TokenService
{
    public function createToken($dataEmail, $dataCode)
    {
        //$private_key = strval(openssl_pkey_new());
        $private_key = "nZr4u7x!A%D*G-KaPdSgVkYp2s5v8y/B?E(H+MbQeThWmZq4t6w9z_C&F)J@NcRf";

//        $public_key_pem = openssl_pkey_get_details($private_key)['key'];
//
//        $public_key = openssl_pkey_get_public($public_key_pem);

        $now_seconds = time();
        $payload = array(
            "iss" => "admin@polybank.ru",
            "iat" => $now_seconds,
            "exp" => $now_seconds+(60),
            "aud" => $dataEmail,
            "code" => $dataCode
        );
        return JWT::encode($payload, $private_key, "HS512");

        //$jwt = JWT::encode($data, $private_key, 'RS256');

        //return $jwt;
    }

    public function fetchToken($user)
    {
        $token = $user->getToken();

        return $token;
    }
}
