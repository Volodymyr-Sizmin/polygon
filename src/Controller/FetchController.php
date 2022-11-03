<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FetchController extends AbstractController
{
    /**
     * @Route("/api/php bin/console debug:router/fetch", name="fetch", methods={"GET"})
     */
    public function matchCodes()
    {
        $userFetched = $this->getDoctrine()->getRepository(User::class)->findAll();
        print_r($userFetched);
    }
}
