<?php

namespace App\Controller;

use App\Entity\Account;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * @Route("/{email}/accounts", name= "app_accounts", methods={"GET"})
     */
    public function getAccounts(string $email): JsonResponse
    {
        $accounts = $this->em->getRepository(Account::class)->findBy(['user_id'=>$email]);

        return new JsonResponse($accounts, Response::HTTP_OK);
    }

    /**
     *@Route("/accounts/{email}/{number}", name="one_account", methods={"GET"})
     */

    public function getAccount(string $email, string $number): JsonResponse
    {
        $account = $this->em->getRepository(Account::class)->findOneBy(['number'=>$number]);

        return new JsonResponse($account, Response::HTTP_OK);
    }
}
