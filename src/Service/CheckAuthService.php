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

    public function checkAuthentication(string $email, $strToken): array
    {

        $token = $this->tokenService->decodeToken(trim(substr($strToken, 7)));

        $tokenEmail = $token->aud;

        if ($tokenEmail !== $email) {
            throw new \DomainException("You are not authorize ", 404);
        }

        return ["success" => "true", "message" => "you pass Authentication"];
    }
}