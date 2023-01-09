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
        $cards = $content->cards;
        $arrCards = [];

        if (count($cards) > 0) {
            foreach ($cards as $card) {
                $oneCard = [];
                $oneCard['id'] = $card->id;
                $oneCard['clientId'] = $card->clientId;
                $oneCard['name'] = $card->name;
                $oneCard['number'] = $card->number;
                $oneCard['expirationDate'] = $card->expirationDate;
                $oneCard['balance'] = $card->balance;
                $oneCard['currency'] = $card->currency;
                $oneCard['limit'] = $card->limit;
                $oneCard['status'] = $card->status;
                $oneCard['cardType'] = $card->cardType;
                $oneCard['pinCode'] = $card->pinCode;
            }
            array_push($arrCards, $oneCard);
        }

        return $arrCards;
    }
}