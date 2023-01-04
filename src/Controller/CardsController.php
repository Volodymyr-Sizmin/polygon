<?php

namespace App\Controller;

use App\Service\CardsInfoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CardsController extends AbstractController
{
    protected $CardsInfoService;

    public function __construct(CardsInfoService $CardsInfoService)
    {
        $this->CardsInfoService = $CardsInfoService;
    }

    /**
     * @Route("/payments_and_transfers/{email}/cards", name="cardslist", methods={"GET"})
     * @param string $email
     * @return JsonResponse|void
     */
    public function cardsList(string $email) : JsonResponse
    {
        $response = $this->CardsInfoService->getCardsInfo($email);

        if (count($response)>0) {
            $jsonStr = [
                'success' => true,
                'cards' => $response
            ];

            return new JsonResponse($jsonStr, Response::HTTP_OK);
        } else {
            $jsonStr = [
                'success' => true
            ];

            return new JsonResponse($jsonStr, Response::HTTP_NO_CONTENT);
        }
    }
}