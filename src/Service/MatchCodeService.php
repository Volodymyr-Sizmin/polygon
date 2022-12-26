<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class MatchCodeService
{
    public function matchCode($attempts, $matchEmail, $session)
    {
        if ($attempts['attempts'] == 0 && $attempts['email'] == $matchEmail) {
            return new JsonResponse(
                [
                    'success' => false,
                    'body' => [
                        'message' => 'Please, wait 10 minutes before next attempt',
                    ],
                    'message' => 0,
                ],
                Response::HTTP_BAD_REQUEST);
        }

        if ($attempts['email'] !== $matchEmail) {
            $session->set('attempts', ['attempts' => 1, 'email' => $matchEmail]);
        }

        if ($attempts['attempts'] == 2 && $attempts['email'] == $matchEmail) {
            $session->set('attempts', ['attempts' => 1, 'email' => $matchEmail]);
        } elseif ($attempts['attempts'] == 1 && $attempts['email'] == $matchEmail) {
            $session->set('attempts', ['attempts' => 0, 'email' => $matchEmail]);
        }
    }
}
