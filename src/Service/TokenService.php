<?php

namespace App\Service;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class TokenService
{
    /*
    @params['0'] - email
    @params['1'] - code
    @params['2'] - codeLifetime
    @params['3'] - isBankClient
    @params['4'] - FirstName
    @params['5'] - LastName
    @params['6'] - Id
    @params['7'] - resident
    @params['8'] - password
    @params['9'] - role
    */
    public function createToken(...$params)
    {
        $private_key = 'nZr4u7x!A%D*G-KaPdSgVkYp2s5v8y/B?E(H+MbQeThWmZq4t6w9z_C&F)J@NcRf';

        $now_seconds = time();
        $firstName = ((isset($params[4])) ? $params[4]['FirstName'] : null);
        $lastName = ((isset($params[5])) ? $params[5]['LastName'] : null);
        $passportId = ((isset($params[6])) ? $params[6]['Id'] : null);
        $resident = ((isset($params[7])) ? intval($params[7]['resident']) : null);
        $is_bank_client = ((isset($params[3])) ? intval($params[3]['isBankClient']) : null);
        $password = ((isset($params[8])) ? $params[8]['password'] : null);
        $role = ((isset($params[9])) ? $params[9]['role'] : null);
        $payload = [
            'iss' => 'admin@polybank.ru',
            'iat' => $now_seconds,
            'exp' => $now_seconds + (1800),
            'aud' => $params[0]['email'],
            'role' => $role,
            'data' => [
                "code" => $params[1]['code'],
                "code_life_time" => $params[2]['codeLifetime'],
                "first_name" => $firstName,
                "last_name" => $lastName,
                "passport_id" => $passportId,
                "resident" => $resident,
                "password" => $password,
                "is_bank_client" => $is_bank_client,
            ]
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
