<?php

namespace App\Service;

use App\Entity\Autopayments;
use App\Entity\CellPhoneOperators;
use App\Entity\User;
use App\Entity\UtilityServices;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AutopaymentService
{
    public TokenService $tokenService;
    public CardsInfoService $cardsInfoService;
    public CardBalanceService $cardBalanceService;

    public function __construct(TokenService $tokenService, CardsInfoService $cardsInfoService, CardBalanceService $cardBalanceService)
    {
        $this->tokenService = $tokenService;
        $this->cardsInfoService = $cardsInfoService;
        $this->cardBalanceService = $cardBalanceService;
    }

    public function getAutopayment($request, $doctrine): JsonResponse
    {
        $authorizationHeader = $this->tokenService->getToken($request);
        $token = $this->tokenService->decodeToken(substr($authorizationHeader, 7));
        $email = $token->data->email;
        $cards = $this->cardsInfoService->getCardsInfo($email);
        $em = $doctrine->getManager();
        $service_category = $em->getRepository(UtilityServices::class)->findAll();
        $categories = [];

        foreach ($service_category as $item) {
            $categories[] = $item->getServiceName();
        }

        $cellPhoneData = $em->getRepository(CellPhoneOperators::class)->findAll();
        $cellPhoneOperators = [];

        foreach ($cellPhoneData as $item) {
            $cellPhoneOperators[] = $item->getName();
        }

        return new JsonResponse([
            'cards' => $cards,
            'categories' => $categories,
            'mobile_phone_operators' => $cellPhoneOperators,
            'message' => 'Success'
        ], Response::HTTP_OK);
    }

    public function createAutopayment($request, $doctrine): JsonResponse
    {
        $authorizationHeader = $this->tokenService->getToken($request);
        $data = json_decode($request->getContent(), true);
        $token = $this->tokenService->decodeToken(substr($authorizationHeader, 7));
        $em = $doctrine->getManager();
        $matchEmail = $token->data->email;
        $user = $em->getRepository(User::class)->findOneBy(['email' => $matchEmail]);

        $autopayment = new Autopayments();

        if (isset($data['cell_phone_operators'])) {
            $autopayment->setCellPhoneOperators($data['cell_phone_operators']);
        } else {
            $autopayment->setCellPhoneOperators('NULL');
        }

        $autopayment->setUserEmail($user->getEmail())
            ->setNameOfPayment($data['name_of_payment'])
            ->setPaymentCategory($data['payment_category'])
            ->setCustomerNumber($data['customer_number'])
            ->setAmount($data['amount'])
            ->setCard($data['card'])
            ->setPaymentsPeriod($data['payments_period'])
            ->setAutoChargeOff($data['auto_charge_off']);
        $em->persist($autopayment);
        $em->flush();
        return new JsonResponse(
            ['message' => 'Autopayment has been created successfully'],
            Response::HTTP_OK);
    }
}