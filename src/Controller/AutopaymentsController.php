<?php

namespace App\Controller;

use App\Service\AutopaymentService;
use App\Service\CardsInfoService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class AutopaymentsController extends AbstractController
{
    protected CardsInfoService $cardInfoService;
    protected AutopaymentService $autopaymentService;

    public function __construct(CardsInfoService $cardInfoService, AutopaymentService $autopaymentService)
    {
        $this->cardInfoService = $cardInfoService;
        $this->autopaymentService = $autopaymentService;
    }

    /**
     * @Route("/payments_and_transfers/autopayment", name="autopayment_get", methods={"GET"})
     */
    public function getAutopayments(Request $request, ManagerRegistry $doctrine)
    {
        $this->autopaymentService->getAutopayment($request, $doctrine);
    }

    /**
     * @Route("/payments_and_transfers/autopayment", name="autopayment_post", methods={"POST"})
     */
    public function createAutopayment(Request $request, ManagerRegistry $doctrine)
    {
        $this->autopaymentService->createAutopayment($request, $doctrine);
    }
}