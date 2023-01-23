<?php

namespace App\Controller;

use App\Service\FastPaymentService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class FastPaymentController extends AbstractController
{
    protected FastPaymentService $fastPaymentService;

    public function __construct(FastPaymentService $fastPaymentService)
    {
        $this->fastPaymentService = $fastPaymentService;
    }

    /**
     * @Route("/payments_and_transfers/fast_payments", name="fast_payments", methods={"GET"})
     */
    public function getFastPayments(ManagerRegistry $doctrine, SerializerInterface $serializer, Request $request): JsonResponse
    {
        $fast_payments = $this->fastPaymentService->getFastPayments($request, $doctrine);
        $result = $serializer->serialize($fast_payments, 'json');
        return new JsonResponse($result, Response::HTTP_OK, [], true );
    }

    /**
     * @Route("/payments_and_transfers/fast_payments/{id}", name="fast_payment", methods={"GET"})
     */
    public function getFastPaymentInfo($id, ManagerRegistry $doctrine, SerializerInterface $serializer, Request $request): JsonResponse
    {
      $fast_payment = $this->fastPaymentService->getFastPaymentInfo($id, $request, $doctrine);
      $result = $serializer->serialize($fast_payment, 'json');
      return new JsonResponse($result, Response::HTTP_OK, [], true );

    }

    /**
     * @Route("/payments_and_transfers/fast_payments/{id}", name="edit_payment", methods={"PUT"})
     */
    public function updateTemplate($id, ManagerRegistry $doctrine, SerializerInterface $serializer, Request $request):JsonResponse
    {
        $fast_payment = $this->fastPaymentService->updateFastPayment($id, $doctrine, $request);
        $result = $serializer->serialize($fast_payment, 'json');
        return new JsonResponse($result, Response::HTTP_OK, [], true );
    }

    /**
     * @Route("/payments_and_transfers/fast_payments/{id}", name="templates_delete", methods={"DELETE"})
     */
    public function deleteTemplate($id, Request $request, ManagerRegistry $doctrine,  SerializerInterface $serializer):JsonResponse
    {
        $fast_payment = $this->fastPaymentService->deleteTemplate($id, $request, $doctrine);
        $result = $serializer->serialize($fast_payment, 'json');
        return new JsonResponse($result, Response::HTTP_OK, [], true );
    }
}
