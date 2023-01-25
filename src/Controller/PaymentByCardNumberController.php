<?php
namespace App\Controller;

use App\DTO\RequestPaymentDTO;
use App\Service\PaymentService;
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

    public function __construct(PaymentService $paymentService, SerializerInterface $serializer)
    {
        $this->paymentService = $paymentService;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/service/payments/{email}/bycardnumber", name="bycardnumber", methods={"POST"})
     * @param $params{'cardNumber', 'amount','cardNumberRecipient'}
     * @return JsonResponse
     */

    public function phonePayment(string $email, Request $request) : JsonResponse
    {
        $authorizationHeader = $request->headers->get('Authorization');
        $strForDTO = json_decode($request->getContent(), true);
        $strForDTO['subject'] = 'By card number';
        $strForDTO['headersAuth'] = $authorizationHeader;

        $resultDTO = $this->serializer->deserialize(json_encode($strForDTO), RequestPaymentDTO::class, 'json');
        $result = $this->paymentService->paymentService($email, $resultDTO);

        return new JsonResponse($result, Response::HTTP_OK);
    }
}