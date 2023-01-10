<?php

namespace App\Controller;

use App\Entity\CellPhoneOperators;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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

  public function cellPhoneOperatorsList(): JsonResponse
  {
        $cellPhoneOperatorsList = $this->entityManager->getRepository(CellPhoneOperators::class)->findAll();

        $forResponseArr = [];

        if (count($cellPhoneOperatorsList) > 0) {

           foreach ($cellPhoneOperatorsList as $item)
           {
               $forResponse =[
                   'id' => $item->getId(),
                   'name' => $item->getName()
               ];

           array_push($forResponseArr,$forResponse );
           }

            return new JsonResponse($forResponseArr, Response::HTTP_OK);
        } else {
            return new JsonResponse($forResponseArr, Response::HTTP_NO_CONTENT);
        }
  }
}