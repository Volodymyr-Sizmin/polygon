<?php

namespace App\Controller;

use App\Entity\CellPhoneOperators;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CellPhoneOperatorsController extends AbstractController
{
    protected $entityManager;

    public function __construct( ManagerRegistry $doctrine)
    {
        $this -> entityManager = $doctrine->getManager();
    }

    /**
     * @Route("/service/operators", name="cell_phone_operators", methods={"GET"})
     * @return JsonResponse
     */

  public function cellPhoneOperatorsList(SerializerInterface $serializer): JsonResponse
  {
        $cellPhoneOperatorsList = $this->entityManager->getRepository(CellPhoneOperators::class)->findAll();
        $result = $serializer->serialize($cellPhoneOperatorsList, 'json');

        return new JsonResponse(json_decode($result), Response::HTTP_OK);
  }
}