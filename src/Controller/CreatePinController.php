<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreatePinController extends AbstractController
{
    #[Route('/create/pin', name: 'app_create_pin')]
    public function index(): Response
    {
        return $this->render('create_pin/index.html.twig', [
            'controller_name' => 'CreatePinController',
        ]);
    }
}
