<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;


class CardsInfoService
{
    protected TokenService $tokenService;
    protected HttpClientInterface $client;

    public function __construct(TokenService $tokenService, HttpClientInterface $client)
    {
        $this->tokenService = $tokenService;
        $this->client = $client;
    }

    public function getCardsInfo(string $email): array
    {
        $dataEmail = ['email' => $email];
        $token = $this->tokenService->createToken(
            $dataEmail,
        );

        $response = $this->client->request('GET', 'https://polygon-application.andersenlab.dev/cards_service/' . $email . '/cards', [
            'headers' => [
                'Authorization' => "Bearer $token",
            ],
        ]);

        $content = json_decode($response->getContent());

        return  $content->cards;
    }
}