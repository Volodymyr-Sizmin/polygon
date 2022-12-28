<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class MatchCodeService
{
    public function matchCode($attempts, $matchEmail, $session)
    {
        if ($this->checkAttempts($attempts, $matchEmail) == false) {
            $session->set('attempts', ['attempts' => 1, 'email' => $matchEmail]);
        } else {
            $count = $session->get('attempts', ['attempts']);
            switch ($attempts['attempts'] == $count && $this->checkAttempts($attempts, $matchEmail)) {
                case $count == 2:
                    $session->set('attempts', ['attempts' => 1, 'email' => $matchEmail]);
                case $count == 1:
                    $session->set('attempts', ['attempts' => 0, 'email' => $matchEmail]);
                case $count == 0:
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
        }
    }

    public function checkAttempts($attempts, $matchEmail): bool
    {
        return $attempts['email'] == $matchEmail;
    }
}
