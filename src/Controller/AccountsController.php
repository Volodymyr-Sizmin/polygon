<?php

namespace App\Controller;

use App\Entity\Account;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountsController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/{email}/accounts", name: "app_accounts", methods={"GET"})
     */

    public function getAccounts(string $email)
    {

        $accounts = $this->em->getRepository(Account::class)->findBy(['user_id'=>$email]);

       dd($accounts);

        return $accounts;
    }

    /**
     *@Route("/accounts/{email}/{card_number}", name: "one_accounts", methods={"GET"})

    public function getAccount(): Response
    {
        return $this->render('accounts/index.html.twig', [
            'controller_name' => 'AccountsController',
        ]);
    }*/
}
