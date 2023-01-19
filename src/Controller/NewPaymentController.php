<?php

namespace App\Controller;

use App\Entity\Currency;
use App\Entity\ExternalAccount;
use App\Entity\ExternalUsers;
use App\Entity\Payment;
use App\Entity\PaymentType;
use App\Service\CardsInfoService;
use App\Service\TokenService;
use App\Service\CardBalanceService;
use App\Service\UserService;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;


class NewPaymentController extends AbstractController
{
    protected TokenService $tokenService;
    protected CardsInfoService $cardsInfoService;
    protected HttpClientInterface $client;
    protected UserService $userService;
    protected CardBalanceService $cardBalanceService;

    public function __construct(
        TokenService        $tokenService,
        CardsInfoService    $cardsInfoService,
        HttpClientInterface $client,
        UserService         $userService,
        CardBalanceService  $updateBalanceService
    )
    {
        $this->tokenService = $tokenService;
        $this->cardsInfoService = $cardsInfoService;
        $this->client = $client;
        $this->userService = $userService;
        $this->cardBalanceService = $updateBalanceService;
    }

    /**
     * @Route("/payments_and_transfers/cards", name="card_info", methods={"GET"})
     */
    public function cardsInfo(Request $request): JsonResponse
    {
        $token = $this->tokenService->getToken($request);
        $decodedToken = $this->tokenService->decodeToken(substr($token, 7));
        $matchEmail = $decodedToken->data->email;
        $cards = $this->cardBalanceService->showCards($matchEmail, $token);

        return new JsonResponse(
            [
                $cards
            ],
            Response::HTTP_OK
        );
    }

    /**
     * @Route("/payments_and_transfers/new_payment", name="new_payment", methods={"POST"})
     * @throws Exception
     */
    public function submitPayment(Request $request, ManagerRegistry $doctrine): JsonResponse
    {
        $token = $this->tokenService->getToken($request);
        $decodedToken = $this->tokenService->decodeToken(substr($token, 7));
        $data = json_decode($request->getContent(), true);
        $userId = $this->userService->getUserID($token);
        $matchEmail = $decodedToken->data->email;

        $cardNumber = $data['card_number'];
        $paymentAmount = $data['payment_amount'];
        $accountNumber = $data['account_number'];
        $name = $data['name'];
        $paymentReason = $data['payment_reason'];
        $paymentDate = $data['payment_date'];
        $timestamp = new \DateTimeImmutable(strtotime($paymentDate));
        $address = $data['address'];
        $nameOfPayment = $data['name_of_payment'];
        $cardId = $this->cardBalanceService->getCardId($matchEmail, $cardNumber, $token);

        $em = $doctrine->getManager();
        $currencyID = $doctrine->getRepository(Currency::class)->findOneBy(['name' => 'GBP']);
        $paymentType = $doctrine->getRepository(PaymentType::class)->findOneBy(['name_id' => 'new_payment']);
        $extUser = $doctrine->getRepository(ExternalUsers::class)->findOneBy(['name' => $name]);
        $extAccount = $doctrine->getRepository(ExternalAccount::class)->findOneBy(['acc_number' => $accountNumber]);

        try {
            $this->cardBalanceService->updateBalance($matchEmail, $cardNumber, $paymentAmount, $token);

            if (!isset($extUser)) {
                $extUser = new ExternalUsers();
                $extUser->setName($name);
                $extUser->setAddress($address);
                $em->persist($extUser);
                $em->flush($extUser);
            }

            $extId = $doctrine->getRepository(ExternalUsers::class)->findOneBy(['name' => $name]);

            if (!isset($extAccount)) {
                $extAccount = new ExternalAccount();
                $extAccount->setAccNumber($accountNumber);
                $extAccount->setExtUserId($extId->getId());
                $em->persist($extAccount);
                $em->flush($extAccount);
            }

            $payment = new Payment();
            $payment->setUserId($matchEmail);
            $payment->setAmount($paymentAmount);
            $payment->setAccountCreditId($cardId);
            $payment->setAccountDebitId($accountNumber);
            $payment->setSubject($paymentReason);
            $payment->setCurrencyId($currencyID->getId());
            $payment->setTypeId($paymentType->getId());
            $payment->setCreatedAt($timestamp);
            $payment->setStatusId(1);
            $em->persist($payment);
            $em->flush($payment);

        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return new JsonResponse(
            [
                'message' => 'Payment was successfully done',
            ],
            Response::HTTP_OK
        );
    }
}