<?php

namespace App\Controller;

use App\DTO\RequestPaymentDTO;
use App\Entity\Account;
use App\Service\PaymentService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class PaymentByCardNumberController extends AbstractController
{
    public Request $request;
    private PaymentService $paymentService;
    private SerializerInterface $serializer;
    const NAME_BY_CARD_NUMBER = 'By card number';
    public function __construct(PaymentService $paymentService, SerializerInterface $serializer)
    {
        $this->paymentService = $paymentService;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/service/payments/{email}/bycardnumber", name="bycardnumber", methods={"POST"})
     * @param $request {'cardNumber', 'amount','cardNumberRecipient', 'subject'}
     * @return JsonResponse
     */

    public function paymentBetweenCards(string $email, Request $request, EntityManagerInterface $em): JsonResponse
    {
        try {
            $authorizationHeader = $request->headers->get('Authorization');
            $strForDTO = json_decode($request->getContent(), true);
            $cardNumber = $strForDTO['cardNumber'];
            $account_credit_obj = $em->getRepository(Account::class)->findOneBy(['cardNumber' => $cardNumber]);
            if($account_credit_obj == null){
                throw new \DomainException('Card '.$cardNumber." didn't find", 404);
            }
            $account_credit = $account_credit_obj->getNumber();
            $strForDTO['name'] = self::NAME_BY_CARD_NUMBER;
            $strForDTO['headersAuth'] = $authorizationHeader;
            $strForDTO['account_credit'] = $account_credit;
            $resultDTO = $this->serializer->deserialize(json_encode($strForDTO), RequestPaymentDTO::class, 'json');
            $result = $this->paymentService->paymentService($email, $resultDTO);
        } catch (\Exception $exception) {
            return new JsonResponse(
                [
                    'success' => false,
                    'body' => [
                        'exception' => get_class($exception),
                        'message' => $exception->getMessage(),
                        'status' => $exception->getCode(),
                        'line' => $exception->getLine(),
                        'file' => $exception->getFile(),
                    ],
                ],
                $exception->getCode());
        }
        return new JsonResponse($result, Response::HTTP_OK);
    }
}