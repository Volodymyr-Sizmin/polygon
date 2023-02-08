<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class UserService
{
    public $client;
    public $tokenService;

    public function __construct(HttpClientInterface $client, TokenService $tokenService)
    {
        $this->client = $client;
        $this->tokenService = $tokenService;
    }

    public function getUserID($token)
    {
        $decodedToken = $this->tokenService->decodeToken(substr($token, 7));
        $matchEmail = $decodedToken->data->email;

        $response = $this->client->request('GET', "https://polygon-application.andersenlab.dev/registration_service/{$matchEmail}", [
            'headers' => [
                'Authorization' => $token,
            ],
        ]);

        if ($response->getStatusCode() == 500) {
            return new JsonResponse(
                [
                    'success' => false
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        try {
            $content = json_decode($response->getContent());
        } catch (ClientExceptionInterface|ServerExceptionInterface|RedirectionExceptionInterface|TransportExceptionInterface $e) {
            return $e;
        }
        $passport_id = $content->passport_id;
        if (!is_int($passport_id)) {
            return new JsonResponse(
                [
                    'success' => false
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        return $passport_id;
    }
}