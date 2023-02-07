<?php

namespace App\Controller;

use App\DTO\RequestPaymentDTO;
use App\Entity\Account;
use App\Service\CheckAuthService;
use App\Service\PaymentService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class PaymentBetweenMyCardsController extends AbstractController
{
    public Request $request;
    protected PaymentService $paymentService;
    protected SerializerInterface $serializer;
    protected CheckAuthService $checkAuth;
    const NAME = 'Between My Cards';

    public function __construct(PaymentService $paymentService, SerializerInterface $serializer, CheckAuthService $checkAuth)
    {
        $this->paymentService = $paymentService;
        $this->serializer = $serializer;
        $this->checkAuth = $checkAuth;
    }

    /**
     * @Route("/service/payments/{email}/betweenmycards", name="betweenmycards", methods={"POST"})
     * @param $request {'cardNumber', 'amount','cardNumberRecipient', 'subject'}
     * @return JsonResponse
     */
    public function paymentBetweenMyCards(string $email, Request $request, EntityManagerInterface $em): JsonResponse
    {
        try {
            $authorizationHeader = $request->headers->get('Authorization');
            $this->checkAuth->checkAuthentication($email, $authorizationHeader);
            $strForDTO = json_decode($request->getContent(), true);
            $cardNumber = $strForDTO['cardNumber'];
            $account_credit_obj = $em->getRepository(Account::class)->findOneBy(['cardNumber' => $cardNumber]);
            if ($account_credit_obj == null) {
                throw new \DomainException("Card " . $cardNumber . " not found", 404);
            }
            $account_credit = $account_credit_obj->getNumber();
            $cardNumberRecipient = $strForDTO['cardNumberRecipient'];
            $account_debit = $em->getRepository(Account::class)->findOneBy(['cardNumber' => $cardNumberRecipient])->getNumber();

            $strForDTO['name'] = NAME;
            $strForDTO['headersAuth'] = $authorizationHeader;
            $strForDTO['account_debit'] = $account_debit;
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