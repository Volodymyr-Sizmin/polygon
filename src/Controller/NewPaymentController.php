<?php

namespace App\Controller;

use Carbon\Carbon;
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
        $address = $data['address'];
        $nameOfPayment = $data['name_of_payment'];

        $em = $doctrine->getManager();
        $payment = $em->getRepository(Payment::class);
        $currentDate = Carbon::now();


        if ($paymentDate == $currentDate->toDateString()) {
            try {
                $this->cardBalanceService->updateBalance($matchEmail, $cardNumber, $paymentAmount, $token);


            } catch (Exception $e) {
                echo $e->getMessage();
            }
        } else {

        }
        return new JsonResponse(
            [
                'message' => 'Payment was successfully done',
                $this->cardBalanceService->showCards($matchEmail, $token)
            ],
            Response::HTTP_OK
        );

    }
}