<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PingController extends AbstractController
{
    /**
     * @Route("/api/ping", methods={"GET"})
     */
    public function ping(): Response
    {
        return $this->json(['success' => 'pong']);
    }
}
