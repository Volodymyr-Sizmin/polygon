<?php

namespace App\Controller;

use App\Entity\CellPhoneOperators;
use App\Service\CardsInfoService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TopUpPhoneController extends AbstractController
{
    protected $CardsInfoService;
    private $entityManager;

    public function __construct(CardsInfoService $CardsInfoService, ManagerRegistry $doctrine)
    {
        $this->CardsInfoService = $CardsInfoService;
        $this -> entityManager = $doctrine->getManager();
    }


    public function index(){
        $cellPhoneOperatorsList = $this ->entityManager->getRepository(CellPhoneOperators::class)->findAll();
    }

}