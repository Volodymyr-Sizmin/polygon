<?php

namespace App\Controller;

use App\Entity\Autopayments;
use App\Entity\CellPhoneOperators;
use App\Entity\UtilityServices;
use App\Entity\User;
use App\Service\CardsInfoService;
use App\Service\TokenService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AutopaymentsController extends AbstractController
{
    protected $tokenService;
    protected $cardInfoService;


    public function __construct(TokenService $tokenService, CardsInfoService $cardInfoService)
    {
        $this->tokenService = $tokenService;
        $this->cardInfoService = $cardInfoService;
    }

    /**
     * @Route("/payments_and_transfers/autopayment", name="autopayment_get", methods={"GET"})
     */
    public function getAutopayments(ManagerRegistry $doctrine, Request $request)
    {
        $authorizationHeader = $request->headers->get('Authorization');
        $token = $this->tokenService->decodeToken(substr($authorizationHeader, 7));

        if (!isset($token)) {
            return new JsonResponse(['status' => 400, 'message' => 'User is unauthorized']);
        }

        $email = $token->data->email;
        $cards = $this->cardInfoService->getCardsInfo($email);

        $em = $doctrine->getManager();
        $service_category = $em->getRepository(UtilityServices::class)->findAll();
        $categories = [];
        foreach ($service_category as $item) {
            array_push($categories, $item->getServiceName());
        }

        $cellPhoneData = $em->getRepository(CellPhoneOperators::class)->findAll();
        $cellPhoneOperators = [];
        foreach ($cellPhoneData as $item) {
            array_push($cellPhoneOperators, $item->getName());
        }

        return new JsonResponse([
            'cards' => $cards,
            'categories' => $categories,
            'mobile_phone_operators' => $cellPhoneOperators,
            'status' => 200,
            'message' => 'Success'
        ]);
    }

    /**
     * @Route("/payments_and_transfers/autopayment", name="autopayment_post", methods={"POST"})
     */
    public function createAutopayment(ManagerRegistry $doctrine, Request $request)
    {
        $authorizationHeader = $request->headers->get('Authorization');
        $token = $this->tokenService->decodeToken(substr($authorizationHeader, 7));

        if (!isset($token)) {
            return new JsonResponse(['status' => 401, 'message' => 'User is unauthorized']);
        }

        $em = $doctrine->getManager();
        $matchEmail = $token->data->email;
        $user = $em->getRepository(User::class)->findOneBy(['email' => $matchEmail]);
        $data = json_decode($request->getContent(), true);
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
        return new JsonResponse(['status' => 201, 'message' => 'Autopayment has been created successfully']);
    }
}

