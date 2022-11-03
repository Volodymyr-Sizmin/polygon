<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CodeGeneratorController extends AbstractController
{
    /**
     * @Route("/registration_service/generatecode", name="clientquestion", methods={"POST"})
     */
    public function generateCode(): Response
    {
        $code = rand(100000, 999999);

        return new JsonResponse(
            [
                'success' => true,
                'body' => [
                    'code' => $code,
                ],
            ],
            200
        );
    }
}
