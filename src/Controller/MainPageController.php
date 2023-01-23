<?php

namespace App\Controller;

//use App\Entity\FastPayment;
use App\Service\MainPageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;
use Symfony\Component\Serializer\SerializerInterface;

class MainPageController extends AbstractController
{
    protected MainPageService $mainPageService;

    public function __construct(MainPageService $mainPageService)
    {
        $this->mainPageService = $mainPageService;
    }

    /**
     * @Route("/payments_and_transfers/fast_payments", name="fast_payments", methods={"GET"})
     */
    public function getFastPayments(ManagerRegistry $managerRegistry, SerializerInterface $serializer): JsonResponse
    {
        $data = $this->mainPageService->getFastPaymentsList();
        $result = $serializer->serialize($data, 'json');

        return new JsonResponse($result, Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/payments_and_transfers/auto_payments", name="auto_payments", methods={"GET"})
     */
    public function getAutoPayments(ManagerRegistry $managerRegistry, SerializerInterface $serializer): JsonResponse
    {
        $data = $this->mainPageService->getAutoPaymentsList();
        $result = $serializer->serialize($data, 'json');

        return new JsonResponse($result, Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/payments_and_transfers/payment_types", name="payment_types", methods={"GET"})
     */
    public function getPaymentTypes(ManagerRegistry $managerRegistry, SerializerInterface $serializer): JsonResponse
    {
        $data = $this->mainPageService->getPaymentTypeList();
        $result = $serializer->serialize($data, 'json');

        return new JsonResponse($result, Response::HTTP_OK, [], true);
    }
}
