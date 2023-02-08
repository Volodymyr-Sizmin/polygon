<?php

namespace App\Controller;

use App\Service\AutopaymentService;
use App\Service\CardsInfoService;
use App\Service\TokenService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class AutopaymentsController extends AbstractController
{
    protected CardsInfoService $cardInfoService;
    protected AutopaymentService $autopaymentService;
    protected TokenService $tokenService;

    public function __construct(CardsInfoService $cardInfoService, AutopaymentService $autopaymentService, TokenService $tokenService)
    {
        $this->cardInfoService = $cardInfoService;
        $this->autopaymentService = $autopaymentService;
        $this->tokenService = $tokenService;
    }

    /**
     * @Route("/payments_and_transfers/autopayment", name="autopayment_get", methods={"GET"})
     */
    public function getAutopayments(Request $request, ManagerRegistry $doctrine)
    {
        return $this->autopaymentService->getAutopayment($request, $doctrine);
    }

    /**
     * @Route("/payments_and_transfers/autopayment", name="autopayment_post", methods={"POST"})
     */
    public function createAutopayment(Request $request, ManagerRegistry $doctrine)
    {
       return $this->autopaymentService->createAutopayment($request, $doctrine);
    }

    /**
     * @Route("/payments_and_transfers/autopayments", name="autopayments", methods={"GET"})
     */
    public function listOfAutopayments(Request $request, ManagerRegistry $doctrine)
    {
        return $this->autopaymentService->listOfAutopayments($request, $doctrine);
    }
}