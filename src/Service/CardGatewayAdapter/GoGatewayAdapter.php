<?php

namespace App\Service\CardGatewayAdapter;

use App\Service\TokenService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GoGatewayAdapter implements Interfaces\CardGatewayAdapter
{
    public const GO_API_ENDPOINT = 'https://polygon-application.andersenlab.dev/cards_service/';
    public const HTTP_METHOD_GET = 'GET';
    public const HTTP_METHOD_POST = 'POST';
    public const HTTP_METHOD_PUT = 'PUT';

    private HttpClientInterface $httpClient;
    private TokenService $tokenService;

    public function __construct(HttpClientInterface $httpClient, TokenService $tokenService)
    {
        $this->httpClient = $httpClient;
        $this->tokenService = $tokenService;
    }

    public function getAllCardsForEmail(string $email, string $token): object
    {
        $endpoint = $email . '/cards';
        $responseBody = $this->apiClient(self::HTTP_METHOD_GET, $endpoint, $token);

        return json_decode($responseBody, false);
    }

    public function getCardDataByNumber(string $email, string $cardNumber, string $token): object
    {
        $endpoint = $email . '/cards/' . $cardNumber;
        $responseBody = $this->apiClient(self::HTTP_METHOD_GET, $endpoint, $token);

        return json_decode($responseBody, false);
    }

    public function getCardBalance(string $email, string $cardNumber, string $token): float
    {
        return (float)$this->getCardDataByNumber($email, $cardNumber, $token)->balance;
    }

    public function updateCardBalance(float $newBalance, string $email, string $cardNumber, string $token): object
    {
        $endpoint = $email . '/cards/' . $cardNumber;
        $jsonBody = ['balance' => $newBalance];
        $responseBody = $this->apiClient(self::HTTP_METHOD_PUT, $endpoint, $token, $jsonBody);

        return json_decode($responseBody, false);
    }

    private function apiClient(string $method, string $endpoint, string $token, array $jsonBody = []): string
    {
        $fullToken = $this->tokenService->getFullToken($token);
        $parameters = $this->setUpApiClientParameters($fullToken, $jsonBody);
        try {
            $fullEndpointUrl = self::GO_API_ENDPOINT . $endpoint;
            $response = $this->httpClient
                ->request(
                    $method,
                    $fullEndpointUrl,
                    $parameters
                );

            return $response->getContent();
        } catch (\Throwable $e) {
            throw new \DomainException('apiClient error:' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function setUpApiClientParameters(string $token, array $jsonBody = []): array
    {
        $parameters['headers'] = ['Authorization' => $token];
        if ($jsonBody) {
            $parameters['json'] = $jsonBody;
        }
        return $parameters;
    }
}
