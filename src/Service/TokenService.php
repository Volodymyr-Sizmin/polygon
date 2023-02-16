<?php

namespace App\Service;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class TokenService
{
    private const PRIVATE_KEY = 'nZr4u7x!A%D*G-KaPdSgVkYp2s5v8y/B?E(H+MbQeThWmZq4t6w9z_C&F)J@NcRf';

    public function createToken(...$params)
    {
        $now_seconds = time();
        $role = ((isset($params['data']['role'])) ? $params['data']['role'] : null);
        $aud = ((isset($params[0]['email'])) ? $params[0]['email'] : $params[0]);
        $payload = [
            'iss' => 'admin@polybank.ru',
            'iat' => $now_seconds,
            'exp' => $now_seconds + (1800),
            'aud' => $aud,
            'role' => $role,
            'data' => array_merge(...$params),
        ];

        return JWT::encode($payload, self::PRIVATE_KEY, 'HS512');
    }

    public function createGoToken(...$params): string
    {
        $now_seconds = time();
        $role = ((isset($params['data']['role'])) ? $params['data']['role'] : null);
        $aud = ((isset($params[0]['email'])) ? $params[0]['email'] : $params[0]);
        $payload = [
            'iss' => 'admin@polybank.ru',
            'iat' => $now_seconds,
            'exp' => $now_seconds + (1800),
            'aud' => $aud,
            'role' => $role,
            'data' => array_merge(...$params),
        ];

        return JWT::encode($payload, self::PRIVATE_KEY, 'HS256');
    }

    public function decodeToken($token)
    {
        $private_key = 'nZr4u7x!A%D*G-KaPdSgVkYp2s5v8y/B?E(H+MbQeThWmZq4t6w9z_C&F)J@NcRf';

        return JWT::decode($token, new Key($private_key, 'HS512'));
    }

    public function decodeTokenHS256($token)
    {
        $private_key = 'nZr4u7x!A%D*G-KaPdSgVkYp2s5v8y/B?E(H+MbQeThWmZq4t6w9z_C&F)J@NcRf';

        return JWT::decode($token, new Key($private_key, 'HS256'));
    }

    public function fetchToken($user)
    {
        $token = $user->getToken();

        return $token;
    }

    public function getToken($request)
    {
        return $request->headers->get('Authorization');
    }

    public function getEmailFromToken($token): string
    {
        if (!isset($token)) {
            throw new \DomainException('Not authenticated', 401);
        }
        $decodedToken = $this->decodeToken($this->getShortifiedToken($token));

        return $decodedToken->data->email;
    }

    public function getEmailFromGoToken(string $token): string
    {
        if (!$token) {
            throw new \DomainException('Not authenticated', 401);
        }

        $decodedToken = $this->decodeTokenHS256($this->getShortifiedToken($token));

        return $decodedToken->aud;
    }

    public function getFullToken(string $token): string
    {
        return false === mb_stripos($token, 'bearer')
            ? 'Bearer '.$token
            : $token;
    }

    public function getShortifiedToken(string $token): string
    {
        return false === mb_stripos($token, 'bearer')
            ? $token
            : substr($token, 7);
    }
}
