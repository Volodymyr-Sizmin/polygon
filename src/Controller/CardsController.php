<?php

namespace App\Controller;

use App\Service\CardsInfoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CardsController extends AbstractController
{
    protected CardsInfoService $cardsInfoService;

    public function __construct(CardsInfoService $cardsInfoService)
    {
        $this->cardsInfoService = $cardsInfoService;
    }

    /**
     * @Route("/payments_and_transfers/{email}/cards", name="cardslist", methods={"GET"})
     * @param string $email
     * @return JsonResponse|void
     */
    public function cardsList(string $email) : JsonResponse
    {
        $response = $this->cardsInfoService->getCardsInfo($email);

        return (count($response)>0 ? new JsonResponse(['success' => true, 'cards' => $response], Response::HTTP_OK) : new JsonResponse(['success' => true], Response::HTTP_NO_CONTENT));
    }
}