<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OneCardInfoService
{
    protected TokenService $tokenService;
    protected HttpClientInterface $client;
    protected SerializerInterface $serializer;

    public function __construct(TokenService $tokenService, HttpClientInterface $client, SerializerInterface $serializer)
    {
        $this->tokenService = $tokenService;
        $this->client = $client;
        $this->serializer = $serializer;
    }

    public function getCardsInfo(string $email, string $cardNumber)
    {
        $dataEmail = ['email' => $email];
        $token = $this->tokenService->createToken(
            $dataEmail,
        );

        $response = $this->client->request('GET', 'https://polygon-application.andersenlab.dev/cards_service/' . $email . '/cards/' . $cardNumber, [
            'headers' => [
                'Authorization' => "Bearer $token",
            ],
        ]);

        $content = json_decode($response->getContent());

        $oneCardInfo = [
            "id" => $content->id,
            "cardNumber" => $content->number,
            "balance" => $content->balance
        ];

        return $oneCardInfo;
    }
}