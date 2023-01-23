<?php

namespace App\Service;

use App\Entity\FastPayments;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

class FastPaymentService
{
    protected TokenService $tokenService;
    protected  CardBalanceService $cardBalanceService;

    public function __construct(TokenService $tokenService, CardBalanceService $cardBalanceService)
    {
        $this->tokenService = $tokenService;
        $this->cardBalanceService = $cardBalanceService;
    }

   public function getFastPayments(Request $request, ManagerRegistry $doctrine)
    {
        $authorizationHeader = $request->headers->get('Authorization');
        if (!isset($authorizationHeader)) {
            return  ['success' => 'false', 'message' => 'Empty token field in request header'];
        }
        $decodedToken  = $this->tokenService->decodeToken(substr($authorizationHeader, 7));
        $email = $decodedToken->data->email;

        return $doctrine->getRepository(FastPayments::class)->findBy(['user_email' => $email]);
    }

   public function getFastPaymentInfo($id, Request $request, ManagerRegistry $doctrine)
    {
        $authorizationHeader = $request->headers->get('Authorization');
        if (!isset($authorizationHeader)) {
            return ['success' => 'false', 'message' => 'Empty token field in request header'];
        }
        $decodedToken  = $this->tokenService->decodeToken(substr($authorizationHeader, 7));
        $email = $decodedToken->data->email;
        $cards = $this->cardBalanceService->showCards($email, $authorizationHeader);
        $fast_payment =  $doctrine->getRepository(FastPayments::class)->find($id);
        if (!$fast_payment || $fast_payment->getUserEmail() !== $email) {
            return ["success" => "false", "message" => "No payment template  found with id $id"];
        }
       return [$fast_payment, $cards];
    }

   public function updateFastPayment($id, ManagerRegistry $doctrine, Request $request)
       {
        $authorizationHeader = $request->headers->get('Authorization');
        if (!isset($authorizationHeader)) {
            return ['success' => 'false', 'message' => 'Empty token field in request header'];
        }
        $decodedToken  = $this->tokenService->decodeToken(substr($authorizationHeader, 7));
        $email = $decodedToken->data->email;

        $entityManager = $doctrine->getManager();
        $fast_payment = $entityManager->getRepository(FastPayments::class)->find($id);

        if (!$fast_payment || $fast_payment->getUserEmail() !== $email) {
            return ['success' => 'false', 'message' => "No payment template  found with id $id"];
        }

        $data = json_decode($request->getContent(), true);

        if (!$data) {
            return ['success' => 'false', 'body' =>
                ['message' => 'Empty input']];
        }
        $fast_payment->setName($data['name']);
        $fast_payment->setCardNumber($data['card_number']);
        $fast_payment->setPaymentReason($data['payment_reason']);
        $fast_payment->setAmount($data['amount']);
        $fast_payment->setAccountNumber($data['account_number']);
        $fast_payment->setAdress($data['adress']);
        $fast_payment->setRecepientName($data['recepient_name']);
        $entityManager->flush();
        return ['success' => 'true', 'message' => 'Payment template was successfully updated'];
    }

    public function deleteTemplate($id, Request $request, ManagerRegistry $doctrine)
    {
        $authorizationHeader = $request->headers->get('Authorization');
        if (!isset($authorizationHeader)) {
            return  ["success" => "false", "Empty token field in request header"];
        }
        $decodedToken  = $this->tokenService->decodeToken(substr($authorizationHeader, 7));
        $email = $decodedToken->data->email;

        $em = $doctrine->getManager();
        $fast_payment = $em->getRepository(FastPayments::class)->find($id);
        if (!$fast_payment || $fast_payment->getUserEmail() !== $email) {
           return  ["success" => "false", "message" => "No payment template  found with id $id"];
        }
        $em->remove($fast_payment);
        $em->flush();
        return  ["success" => "true", 'body' => [
            'message' => 'Payment template was successfully deleted' ]];
    }
}
