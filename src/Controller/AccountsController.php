<?php

namespace App\Controller;

use App\Entity\Account;
use App\Service\AuthorizationService;
use App\Service\Interfaces\Accounts;
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

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/accounts/{email}", name= "app_accounts", methods={"GET"})
     */
    public function getAccounts(string $email): JsonResponse
    {
        $accounts = $this->em->getRepository(Account::class)->findBy(['user_id' => $email]);
        $account_arr = [];
        /** @var $one_account Account */
        foreach ($accounts as $one_account) {
            $foreResponse = [
                'id' => $one_account->getId(),
                'user_id' => $one_account->getUserId(),
                'number' => $one_account->getNumber(),
                'currency_id' => $one_account->getCurrencyId(),
            ];

            array_push($account_arr, $foreResponse);
        }

        return new JsonResponse($account_arr, Response::HTTP_OK);
    }

    /**
     *@Route("/accounts/{email}/{number}", name="one_account", methods={"GET"})
     */
    public function getAccount(string $email, string $number, SerializerInterface $serializer): JsonResponse
    {
        /** @var $account Account */
        $account = $this->em->getRepository(Account::class)->findOneBy(['number' => $number]);
        $content = $serializer->serialize($account, 'json');

        return new JsonResponse(json_decode($content), Response::HTTP_OK);
    }

    /**
     * @Route("/accounts/create", name="create_account", methods={"POST"})
     */
    public function createAccount(
        Request $request,
        Accounts $accountsService,
        AuthorizationService $authorizationService
    ): JsonResponse {
        $authToken = $request->headers->get('Authorization') ?? '';
        $email = $authorizationService->getEmailFromHeaderToken($authToken);
        $accountNumber = $accountsService->createAccountByEmail($email);

        return new JsonResponse($accountNumber, Response::HTTP_OK);
    }
}
