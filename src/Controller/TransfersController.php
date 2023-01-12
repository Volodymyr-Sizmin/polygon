<?php

namespace App\Controller;

use App\Entity\Transfers;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class TransfersController extends AbstractController
{
    /**
     * @Route("/payments_and_transfers/transfers", name="transfers", methods={"GET"})
     */
    public function getServices(ManagerRegistry $managerRegistry, SerializerInterface $serializer): JsonResponse
    {
        $data = $managerRegistry->getManager()->getRepository(Transfers::class)->findAll();
        $result = $serializer->serialize($data, 'json');

        return new JsonResponse($result, Response::HTTP_OK, [], true);
    }
}