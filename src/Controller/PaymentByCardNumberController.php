<?php
namespace App\Controller;

use App\Service\PaymentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentByCardNumberController extends AbstractController
{
    public Request $params;
    private PaymentService $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * @Route("/service/payments/{email}/bycardnumber", name="bycardnumber", methods={"POST"})
     * @param $params{'cardNumber', 'amount','cardNumberRecipient', 'subject'}
     * @return JsonResponse
     */

    public function phonePayment(string $email, Request $params) : JsonResponse
    {
        $result = $this->paymentService->paymentService($email, $params);

        return new JsonResponse($result,Response::HTTP_OK);
    }
}