<?php

namespace App\Controller;

use App\Service\MainPageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
     * @Route("/payments_and_transfers/payment_types", name="payment_types", methods={"GET"})
     */
    public function getPaymentTypes(SerializerInterface $serializer): JsonResponse
    {
        $data = $this->mainPageService->getPaymentTypeList();
        $result = $serializer->serialize($data, 'json');

        return new JsonResponse($result, Response::HTTP_OK, [], true);
    }
}
