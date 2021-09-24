<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PingController extends AbstractController
{
    /**
    * @api {get} /api/ping Request User information
    * @apiName GetApiPing
    * @apiGroup Test
    *
    * @apiSuccess (200) {String} success Should say pong
    * 
    */
    /**
     * @Route("/api/ping", methods={"GET"})
     */
    public function ping(): Response
    {
        return $this->json(['success' => 'pong']);
    }
}
