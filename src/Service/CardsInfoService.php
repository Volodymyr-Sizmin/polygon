<?php

namespace App\Service;

use App\DTO\Transformer\CardTransformerDTO;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;


class CardsInfoService
{
    protected TokenService $tokenService;
    protected HttpClientInterface $client;
    protected EntityManagerInterface $em;
    protected CardTransformerDTO $cardTransformerDTO;

    public function __construct(TokenService $tokenService, HttpClientInterface $client, EntityManagerInterface $em, CardTransformerDTO $cardTransformerDTO)
    {
        $this->tokenService = $tokenService;
        $this->client = $client;
        $this->em = $em;
        $this->cardTransformerDTO = $cardTransformerDTO;
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
        $query = "
        SELECT card.*, accounts.balance, accounts.number as account_number
        FROM card
        LEFT JOIN accounts ON card.account_number = accounts.number
        WHERE card.user_id LIKE :user_id
        ";

        $query_result = $this->em
            ->getConnection("default")
            ->prepare($query)
            ->executeQuery(['user_id' => $userId])
            ->fetchAllAssociative();
        if (!$query_result) {
            throw new \DomainException('Cards for user '.$userId.' are not found', 404);
        }

        $result = $this->cardTransformerDTO->transformCards($query_result);
        return $result;
    }

    public function getOneCardWithBalance(string $userId, string $number)
    {
        $query = "
        SELECT card.*, accounts.balance, accounts.number as account_number
        FROM card
        LEFT JOIN accounts ON card.account_number = accounts.number
        WHERE card.user_id LIKE :user_id AND card.number = :number
        ORDER BY card.created_at
        ";

        $query_result = $this->em
            ->getConnection("default")
            ->prepare($query)
            ->executeQuery(['user_id' => $userId, 'number' => $number])
            ->fetchAssociative();

        if (!$query_result) {
            throw new \DomainException('Card '.$number.' is not found', 404);
        }

        $result = $this->cardTransformerDTO->transformOneCard($query_result);
        return $result;
    }
}