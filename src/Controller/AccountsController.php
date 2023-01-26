<?php

namespace App\Controller;

use App\Entity\Account;
use App\Service\Interfaces\Accounts;
use App\Service\Interfaces\Authorization;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class AccountsController extends AbstractController
{
    private EntityManagerInterface $em;
    private Authorization $authorizationService;

    public function __construct(EntityManagerInterface $em, Authorization $authorizationService)
    {
        $this->em = $em;
        $this->authorizationService = $authorizationService;
    }

    /**
     * @Route("/accounts/{email}", name= "app_accounts", methods={"GET"})
     */
    public function getAccounts(string $email, SerializerInterface $serializer): JsonResponse
    {
        $accounts = $this->em->getRepository(Account::class)->findBy(['user_id' => $email]);
        $content = $serializer->serialize($accounts, 'json');

        return new JsonResponse($content, Response::HTTP_OK, [], true);
    }

    /**
     *@Route("/accounts/{email}/{number}", name="one_account", methods={"GET"})
     */
    public function getAccount(string $email, string $number, SerializerInterface $serializer): JsonResponse
    {
        /** @var $account Account */
        $account = $this->em->getRepository(Account::class)->findOneBy(['number' => $number]);
        $content = $serializer->serialize($account, 'json');

        return new JsonResponse($content, Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/accounts/create", name="create_account", methods={"POST"})
     */
    public function createAccount(
        Request $request,
        Accounts $accountsService
    ): JsonResponse {
        $authToken = $request->headers->get('Authorization') ?? '';
        $email = $this->authorizationService->getEmailFromHeaderToken($authToken);
        $accountNumber = $accountsService->createAccountByEmail($email);

        return new JsonResponse($accountNumber, Response::HTTP_OK);
    }
}
