<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;


class CardsInfoService
{
    protected TokenService $tokenService;
    protected HttpClientInterface $client;
    protected EntityManagerInterface $em;

    public function __construct(TokenService $tokenService, HttpClientInterface $client, EntityManagerInterface $em)
    {
        $this->tokenService = $tokenService;
        $this->client = $client;
        $this->em = $em;
    }

    public function getCardsInfo(string $email): array
    {
        $dataEmail = ['email' => $email];
        $token = $this->tokenService->createToken(
            $dataEmail,
        );
       //http://10.10.14.46:8686/
        $response = $this->client->request('GET', 'https://polygon-application.andersenlab.dev/cards_service/' . $email . '/cards', [
            'headers' => [
                'Authorization' => "Bearer $token",
            ],
        ]);

        $content = json_decode($response->getContent());

        return $content->cards;
    }

    public function getCardsWithBalance(string $userId)
    {
        $query ="
        SELECT card.*, accounts.balance, accounts.number
        FROM card
        LEFT JOIN accounts ON card.account_number = accounts.number
        WHERE card.user_id LIKE :user_id
        ";

        return $this->em
            ->getConnection("default")
            ->prepare($query)
            ->executeQuery(['user_id'=>$userId])
            ->fetchAllAssociative();
    }

    public function getOneCardWithBalance(string $userId, $id)
    {
        $query ="
        SELECT card.*, accounts.balance, accounts.number
        FROM card
        LEFT JOIN accounts ON card.account_number = accounts.number
        WHERE card.user_id LIKE :user_id AND card.user_id = :id
        ORDER BY card.created_at
        ";

        return $this->em
            ->getConnection("default")
            ->prepare($query)
            ->executeQuery(['user_id'=>$userId, 'id'=>$id])
            ->fetchAllAssociative();
    }
}