<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class PhonePaymentService
{
    protected TokenService $tokenService;
    protected HttpClientInterface $client;

    public function __construct(TokenService $tokenService, HttpClientInterface $client)
    {
        $this->tokenService = $tokenService;
        $this->client = $client;
    }

    public function PhonePayment(string $email, array $params):array
    {
        $dataEmail = ['email' => $email];
        $token = $this->tokenService->createToken(
            $dataEmail,
        );

        $cardResponse = $this->client->request('GET', 'https://polygon-application.andersenlab.dev/cards_service/' . $email . '/cards/' . $params['cardNumber'], [
            'headers' => [
                'Authorization' => "Bearer $token",
            ],
        ]);

        $cardContent = json_decode($cardResponse->getContent());
        $oldBalance = $cardContent->balance;
        $amount = $params['amount'];

        if ($oldBalance > $amount) {

            $newBalance = ($oldBalance * 100 - $amount * 100) / 100;

            $balanceUpd = $this->client->request('PUT', 'https://polygon-application.andersenlab.dev/cards_service/' . $email . '/cards/' . $params['cardNumber'], [
                'headers' => [
                    'Authorization' => "Bearer $token",
                ],
                'json' => ['balance' => $newBalance],
            ]);
        }

        if ($balanceUpd->getStatusCode() == 200) {

            $cardResponseNew = $this->client->request('GET', 'https://polygon-application.andersenlab.dev/cards_service/' . $email . '/cards/' . $params['cardNumber'], [
                'headers' => [
                    'Authorization' => "Bearer $token",
                ],
            ]);

            $newCardContent = json_decode($cardResponseNew->getContent());
            $balance = $newCardContent->balance * 100;
            $checksum = ($oldBalance - $amount) * 100 ;

            if ($checksum === $balance) {

                return ["success" => "true"];
            } else {

                return ["success" => "false", "message" => "funds were debited incorrectly. contact the bank"];
            }
        } else {

            return ["success" => "false", "message" => "payment failed"];
        }
    }
}