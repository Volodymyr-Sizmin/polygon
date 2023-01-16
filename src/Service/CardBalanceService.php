<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CardBalanceService
{
    public HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function showCards($email, $token)
    {
        $response = $this->client->request('GET', "https://polygon-application.andersenlab.dev/cards_service/{$email}/cards", [
            'headers' => [
                'Authorization' => $token
            ],
        ]);

        $content = json_decode($response->getContent());
        return $content->cards;
    }

    public function updateBalance($email, $cardNumber, $paymentAmount, $token)
    {
        $cards = $this->showCards($email, $token);

        $response = $this->client->request('GET', "https://polygon-application.andersenlab.dev/cards_service/{$email}/cards/{$cardNumber}", [
            'headers' => [
                'Authorization' => $token
            ]
        ]);
        $content = json_decode($response->getContent());
        $balance = $content->balance;

        if ($balance > $paymentAmount) {
            $newBalance = $balance - $paymentAmount;
            $this->client->request('PUT', "https://polygon-application.andersenlab.dev/cards_service/{$email}/cards/{$cardNumber}", [
                'headers' => [
                    'Authorization' => $token,
                ],
                'json' => ['balance' => $newBalance]
            ]);
        } else {
            return new JsonResponse([
                'success' => false,
                'message' => 'You haven\'nt enough money on your card'
            ], Response::HTTP_OK);
        }
    }
}