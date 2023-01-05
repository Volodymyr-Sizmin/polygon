<?php

namespace App\Controller;

use App\Entity\Service;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;
use Symfony\Component\Serializer\SerializerInterface;


class ServiceController extends AbstractController
{
    /**
     * @Route("/payments_and_transfers/services", name="services", methods={"GET"})
     */
    public function getServices(ManagerRegistry $managerRegistry, SerializerInterface $serializer): JsonResponse
    {
        $data = $managerRegistry->getManager()->getRepository(Service::class)->findAll();
        $result = $serializer->serialize($data, 'json');

        return new JsonResponse($result, Response::HTTP_OK, [], true);
    }
}
