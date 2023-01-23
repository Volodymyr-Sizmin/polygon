<?php

namespace App\Service;

use App\Service\Interfaces\Authorization;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class AuthorizationService implements Authorization
{
    public function getEmailFromHeaderToken(string $authorizationToken, TokenService $tokenService): string
    {
        if (!$authorizationToken) {
            throw new AuthenticationException('Not authenticated', Response::HTTP_UNAUTHORIZED);
        }
        $tokenData = $tokenService->decodeToken(substr($authorizationToken, 7));
        $email = $tokenData->data->email ?? false;
        if (!$email) {
            throw new \DomainException('No email provided', Response::HTTP_BAD_REQUEST);
        }

        return $email;
    }
}
