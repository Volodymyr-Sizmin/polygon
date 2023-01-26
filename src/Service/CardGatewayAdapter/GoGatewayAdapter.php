<?php

namespace App\Service\CardGatewayAdapter;

use App\Service\TokenService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GoGatewayAdapter implements Interfaces\CardGatewayAdapter
{
    private const GO_API_ENDPOINT = 'https://polygon-application.andersenlab.dev/cards_service/';
    private const HTTP_METHOD_GET = 'GET';
    private const HTTP_METHOD_POST = 'POST';
    private const HTTP_METHOD_PUT = 'PUT';

    private HttpClientInterface $httpClient;

    public function __construct(HttpClientInterface $httpClient, TokenService $tokenService)
    {
        $this->httpClient = $httpClient;
    }

    public function getAllCardsForClient(string $email, string $token): object
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

    public function updateCardBalance(float $newBalance, string $email, string $cardNumber, string $token): void
    {
        $jsonBody = ['balance' => $newBalance];
        $this->apiClient(self::HTTP_METHOD_PUT, $email, $cardNumber, $jsonBody);
    }

    private function apiClient(string $method, string $endpoint, string $token, array $jsonBody = []): string
    {
        $parameters = $this->setUpApiClientParameters($token, $jsonBody);

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
