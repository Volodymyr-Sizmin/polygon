<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CheckAuthService
{
    protected TokenService $tokenService;
    protected HttpClientInterface $client;

    public function __construct(TokenService $tokenService, HttpClientInterface $client)
    {
        $this->tokenService = $tokenService;
        $this->client = $client;
    }

    public function checkAuthentication(string $email, Request $request)
    {
        $authorizationHeader = $request->headers->get('Authorization');

        if (!isset($authorizationHeader)) {

            return  ["success" => "false", "message" => "you are not authorized"];
        }

        $token = $this->tokenService->decodeToken(trim(substr($authorizationHeader, 7)));

        $tokenEmail = $token->aud;

        if ($tokenEmail !== $email) {
            return  ["success" => "false", "message" => "you are not authorized"];
        }

        return ["success" => "true", "message" => "you pass Authentication"];
    }
}