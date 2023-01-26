<?php

namespace App\Controller;

use App\Service\CardsInfoService;
use App\Service\CardBalanceService;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


class NewPaymentController extends AbstractController
{
    protected CardsInfoService $cardsInfoService;
    protected CardBalanceService $cardBalanceService;

    public function __construct(CardsInfoService $cardsInfoService, CardBalanceService $updateBalanceService) {
        $this->cardsInfoService = $cardsInfoService;
        $this->cardBalanceService = $updateBalanceService;
    }

    /**
     * @Route("/payments_and_transfers/new_payment", name="card_info", methods={"GET"})
     */
    public function cardsInfo(Request $request): JsonResponse
    {
        return $this->cardBalanceService->showCards($request);
    }

    /**
     * @Route("/payments_and_transfers/new_payment", name="new_payment", methods={"POST"})
     * @throws Exception
     */
    public function submitPayment(Request $request, ManagerRegistry $doctrine)
    {
        return $this->cardBalanceService->submitPayment($request, $doctrine);
    }
}