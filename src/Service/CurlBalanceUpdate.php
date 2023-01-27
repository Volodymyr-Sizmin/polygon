<?php

namespace App\Service;

use phpDocumentor\Reflection\Types\Mixed_;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CurlBalanceUpdate
{
    protected TokenService $tokenService;
    protected HttpClientInterface $client;

    public function __construct(TokenService $tokenService, HttpClientInterface $client)
    {
        $this->tokenService = $tokenService;
        $this->client = $client;
    }

    public function curlBalanceUpd(string $email, string $cardNumber, int $balance): void
    {

        $dataEmail = ['email' => $email];
        $token = $this->tokenService->createToken($dataEmail);

        $this->client->request('PUT', 'http://10.10.14.46:8686/' . $email . '/cards/' . $cardNumber, [
            'headers' => [
                'Authorization' => "Bearer $token",
            ],
            'json' => ['balance' => $balance],
        ]);
    }
}