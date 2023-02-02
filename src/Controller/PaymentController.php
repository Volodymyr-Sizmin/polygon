<?php

namespace App\Controller;

use App\Service\TokenService;
use App\Service\PaymentHistoryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Serializer\SerializerInterface;

class PaymentController extends AbstractController
{
    protected TokenService $tokenService;
    protected PaymentHistoryService $paymentHistoryService;

    public function __construct(TokenService $tokenService, PaymentHistoryService $paymentHistoryService)
    {
        $this->tokenService = $tokenService;
        $this->paymentHistoryService = $paymentHistoryService;
    }

    /**
     * @Route("/payments_and_transfers/history", name="history", methods={"GET"})
     */
    public function getHistoryOfPayments(ManagerRegistry $doctrine, SerializerInterface $serializer, Request $request): JsonResponse
    {
        $token = $this->tokenService->getToken($request);
        $decodedToken = $this->tokenService->decodeToken(substr($token, 7));

        $data = $this->paymentHistoryService->getHistoryOfPayments($decodedToken, $doctrine);

        $result = $serializer->serialize($data, 'json');

        return new JsonResponse($result, Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/payments_and_transfers/filter_history", name="filter_history", methods={"GET"})
     */
    public function filterHistoryOfPayments(ManagerRegistry $doctrine, SerializerInterface $serializer, Request $request): JsonResponse
    {
        $token = $this->tokenService->getToken($request);
        $decodedToken = $this->tokenService->decodeToken(substr($token, 7));

        $payments = $this->paymentHistoryService->getFilteredHistoryOfPayments($decodedToken, $request, $doctrine);
        $result = $serializer->serialize($payments, 'json');

        return new JsonResponse($result, Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/payments_and_transfers/sort_history", name="sort_history", methods={"GET"})
     */
    public function sortHistoryOfPayments(ManagerRegistry $doctrine, SerializerInterface $serializer, Request $request): JsonResponse
    {
        $token = $this->tokenService->getToken($request);
        $decodedToken = $this->tokenService->decodeToken(substr($token, 7));

        $payments = $this->paymentHistoryService->getSortedHistoryOfPayments($decodedToken, $request, $doctrine);
        $result = $serializer->serialize($payments, 'json');

        return new JsonResponse($result, Response::HTTP_OK, [], true);
    }
}

