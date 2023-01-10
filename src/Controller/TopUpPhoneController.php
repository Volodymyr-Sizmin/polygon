<?php
namespace App\Controller;

use App\Service\PhonePaymentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TopUpPhoneController extends AbstractController
{
    public Request $params;
    private PhonePaymentService $phonePaymentService;

    public function __construct(PhonePaymentService $phonePaymentService)
    {
        $this->phonePaymentService = $phonePaymentService;
    }

    /**
     * @Route("/service/payments/{email}/topupphone", name="topupphone", methods={"POST"})
     * @param $params{'phone_number', 'id_operator', 'amount','cardNumber'}
     * @return JsonResponse
     */

    public function phonePayment(string $email, Request $params) : JsonResponse
    {

        $data = json_decode($params->getContent(), true);
        $result = $this->phonePaymentService->PhonePayment($email, $data);

        return new JsonResponse($result,Response::HTTP_OK);
    }

}