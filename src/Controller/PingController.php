<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @IgnoreAnnotation("apiName")
 * @IgnoreAnnotation("apiGroup")
 * @IgnoreAnnotation("apiSuccess")
 */
class PingController extends AbstractController
{
    /**
    * @api {get} /backend/api/ping Ping server
    * @apiName GetApiPing
    * @apiGroup Test
    *
    * @apiSuccess (200) {String} success Should say pong
    * 
    */
    public function ping(): Response
    {
        return $this->json(['success' => 'pong']);
    }
}
