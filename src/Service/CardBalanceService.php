<?php

namespace App\Service;

use App\Entity\Currency;
use App\Entity\ExternalAccount;
use App\Entity\ExternalUsers;
use App\Entity\FastPayments;
use App\Entity\Payment;
use App\Entity\PaymentType;
use Carbon\Carbon;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;


class CardBalanceService
{
    public HttpClientInterface $client;
    public TokenService $tokenService;
    public UserService $userService;
    public ManagerRegistry $doctrine;

    public function __construct(HttpClientInterface $client, TokenService $tokenService, UserService $userService, ManagerRegistry $doctrine)
    {
        $this->client = $client;
        $this->tokenService = $tokenService;
        $this->userService = $userService;
        $this->doctrine = $doctrine;
    }

    public function showCards($request)
    {
        $token = $this->tokenService->getToken($request);
        $decodedToken = $this->tokenService->decodeToken(substr($token, 7));
        $email = $decodedToken->data->email;
        $response = $this->client->request('GET', "https://polygon-application.andersenlab.dev/cards_service/$email/cards", [
            'headers' => [
                'Authorization' => $token
            ],
        ]);

        $content = json_decode($response->getContent());

        return new JsonResponse(
            [
                $content->cards
            ],
            Response::HTTP_OK
        );
    }

    public function updateBalance($request, $email, $cardNumber, $paymentAmount, $token)
    {
        $cards = $this->showCards($request);

        $response = $this->client->request('GET', "https://polygon-application.andersenlab.dev/cards_service/$email/cards/$cardNumber", [
            'headers' => [
                'Authorization' => $token
            ]
        ]);
        $content = json_decode($response->getContent());
        $balance = $content->balance;

        if ($balance > $paymentAmount) {
            $newBalance = $balance - $paymentAmount;
            $this->client->request('PUT', "https://polygon-application.andersenlab.dev/cards_service/{$email}/cards/{$cardNumber}", [
                'headers' => [
                    'Authorization' => $token,
                ],
                'json' => ['balance' => $newBalance]
            ]);
        } else {
            return new JsonResponse([
                'success' => false,
                'message' => 'You haven\'nt enough money on your card'
            ], Response::HTTP_OK);
        }
    }

    public function getCardId($email, $cardNumber, $token)
    {
        $response = $this->client->request('GET', "https://polygon-application.andersenlab.dev/cards_service/$email/cards/$cardNumber", [
            'headers' => [
                'Authorization' => $token
            ]
        ]);
        $content = json_decode($response->getContent());
        return $content->id;
    }

    public function submitPayment($request, $doctrine)
    {
        $token = $this->tokenService->getToken($request);
        $data = json_decode($request->getContent(), true);
        $decodedToken = $this->tokenService->decodeToken(substr($token, 7));
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
        $cardId = $this->getCardId($matchEmail, $cardNumber, $token);

        $em = $doctrine->getManager();
        $currencyID = $doctrine->getRepository(Currency::class)->findOneBy(['name' => 'GBP']);
        $paymentType = $doctrine->getRepository(PaymentType::class)->findOneBy(['name_id' => 'new_payment']);
        $extUser = $doctrine->getRepository(ExternalUsers::class)->findOneBy(['name' => $name]);
        $extAccount = $doctrine->getRepository(ExternalAccount::class)->findOneBy(['acc_number' => $accountNumber]);

        try {
            $this->updateBalance($request, $matchEmail, $cardNumber, $paymentAmount, $token);

            if (!isset($extUser)) {
                $extUser = new ExternalUsers();
                $extUser->setName($name);
                $extUser->setAddress($address);
                $em->persist($extUser);
                $em->flush($extUser);
            }

            if ($nameOfPayment) {
                $paymentType = new PaymentType();
                $paymentType->setNameId($nameOfPayment);
                $paymentType->setName($nameOfPayment);
                $paymentType->setOnTheMainPage(0);
                $em->persist($paymentType);
                $em->flush($paymentType);
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

            if($data['name_of_payment']){
                $fastPayment = new FastPayments();
                $fastPayment->setUserEmail($matchEmail);
                $fastPayment->setName($data['name_of_payment']);
                $fastPayment->setCardNumber($data['card_number']);
                $fastPayment->setPaymentReason($data['payment_reason']);
                $fastPayment->setAmount($data['payment_amount']);
                $fastPayment->setAccountNumber($data['account_number']);
                $fastPayment->setAddress($data['address']);
                $fastPayment->setRecepientName('John Connor');
                $em->persist($fastPayment);
                $em->flush($fastPayment);
            }


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


    public function processAutopayment($autopayment)
    {
        $em = $this->doctrine->getManager();
        $email = $autopayment['email'];
        $token = $this->tokenService->createToken($email);
        $paymentAmount = $autopayment['payment_amount'];
        $cardNumber = $autopayment['card'];
        $cardDebitNumber = $autopayment['card_debit_number'];
        $paymentReason = $autopayment['name_of_payment'];
        $paymentType = $autopayment['payment_category'];
        $timestamp = new \DateTimeImmutable(strtotime(Carbon::now()));
        $currencyID = $this->doctrine->getRepository(Currency::class)->findOneBy(['name' => 'GBP']);

        $response = $this->client->request('GET', "https://polygon-application.andersenlab.dev/cards_service/$email/cards/$cardNumber", [
            'headers' => [
                'Authorization' => $token
            ]
        ]);

        $content = json_decode($response->getContent());
        $balance = $content->balance;

        if ($balance > $paymentAmount) {
            try {
                $newBalance = $balance - $paymentAmount;
                $this->client->request('PUT', "https://polygon-application.andersenlab.dev/cards_service/{$email}/cards/{$cardNumber}", [
                    'headers' => [
                        'Authorization' => $token,
                    ],
                    'json' => ['balance' => $newBalance]
                ]);

                $payment = new Payment();
                $payment->setUserId($email);
                $payment->setAmount($paymentAmount);
                $payment->setAccountCreditId($cardNumber);
                $payment->setAccountDebitId($cardDebitNumber);
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
        }
    }
}