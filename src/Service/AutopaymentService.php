<?php

namespace App\Service;

use App\Entity\Autopayments;
use App\Entity\CellPhoneOperators;
use App\Entity\User;
use App\Entity\UtilityServices;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AutopaymentService
{
    public TokenService $tokenService;
    public CardsInfoService $cardsInfoService;
    public CardBalanceService $cardBalanceService;

    public function __construct(
        TokenService $tokenService,
        CardsInfoService $cardsInfoService,
        CardBalanceService $cardBalanceService
    ) {
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
        $authUserEmail = $token->data->email;

        $autopayment = new Autopayments();

        if (isset($data['cell_phone_operators'])) {
            $autopayment->setCellPhoneOperators($data['cell_phone_operators']);
        } else {
            $autopayment->setCellPhoneOperators('NULL');
        }

        $autopayment->setUserEmail($authUserEmail)
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
            Response::HTTP_OK
        );
    }

    public function listOfAutopayments($request, $doctrine): JsonResponse
    {
        $authorizationHeader = $this->tokenService->getToken($request);
        $token = $this->tokenService->decodeToken(substr($authorizationHeader, 7));
        $matchEmail = $token->data->email;
        $em = $doctrine->getManager();

        $autopaymentsList = $em->getRepository(Autopayments::class)->findBy(['user_email' => $matchEmail]);

        foreach ($autopaymentsList as $item) {
            $autopayment[] = [
                'id' => $item->getId(),
                'name_of_payment' => $item->getNameOfPayment(),
                'payment_category' => $item->getPaymentCategory(),
                'created_at' => $item->getCreatedAt(),
            ];
        }

        if (empty($autopayment)) {
            return new JsonResponse(
                [],
                Response::HTTP_OK
            );
        }

        return new JsonResponse(
            $autopayment,
            Response::HTTP_OK
        );
    }

    public function showAutopayment(int $id, Request $request, ManagerRegistry $doctrine): JsonResponse
    {
        $autopayment = $doctrine->getRepository(Autopayments::class)->find($id);

        if (!$autopayment || !$this->checkAuthUser($request, $autopayment->getUserEmail())) {
            return new JsonResponse(
                [], //"message" => "You do not have such autopayment"
                Response::HTTP_OK
            );
        }

        $response = [
            'id' => $autopayment->getId(),
            'name_of_payment' => $autopayment->getNameOfPayment(),
            'payment_category' => $autopayment->getPaymentCategory(),
            'created_at' => $autopayment->getCreatedAt(),
            'autoChargeStatus' => $autopayment->getAutoChargeOff()
        ];

        return new JsonResponse(
            $response,
            Response::HTTP_OK
        );
    }

    public function pauseSwitcherAutopayment(int $id, Request $request, ManagerRegistry $doctrine): JsonResponse
    {
        $autopayment = $doctrine->getRepository(Autopayments::class)->find($id);
        $data = json_decode($request->getContent(), true);
        $autopaymentStatusRequest = $data['auto_charge_off'];

        if (!$autopayment || !$this->checkAuthUser($request, $autopayment->getUserEmail())) {
            return new JsonResponse(
                [],
                Response::HTTP_OK
            );
        }

        if ($autopayment->getAutoChargeOff() == $autopaymentStatusRequest) {
            return new JsonResponse(
                ["message" => "This autopayment status has already been enabled"],
                Response::HTTP_OK
            );
        }

        $autopayment->setAutoChargeOff($autopaymentStatusRequest);
        $doctrine->getManager()->flush();

        $response = ['message' => 'Autopayment status has been changed successfully'];

        return new JsonResponse(
            $response,
            Response::HTTP_OK
        );
    }

    public function deleteAutopayment(int $id, Request $request, ManagerRegistry $doctrine): JsonResponse
    {
        $autopayment = $doctrine->getRepository(Autopayments::class)->find($id);
        if (!$autopayment || !$this->checkAuthUser($request, $autopayment->getUserEmail())) {
            return new JsonResponse(
                [],
                Response::HTTP_OK
            );
        }
        $doctrine->getManager()->remove($autopayment);
        $doctrine->getManager()->flush();

        $response = ['message' => 'Autopayment  has been deleted successfully'];

        return new JsonResponse(
            $response,
            Response::HTTP_OK
        );
    }

    private function checkAuthUser(Request $request, string $autopaymentUserEmail): bool
    {
        $authorizationHeader = $this->tokenService->getToken($request);
        $token = $this->tokenService->decodeToken(substr($authorizationHeader, 7));
        $email = $token->data->email;

        return $email === $autopaymentUserEmail;
    }
}
