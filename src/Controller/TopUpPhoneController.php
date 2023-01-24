<?php
namespace App\Controller;

use App\DTO\RequestDTO;
use App\Entity\CellPhoneOperators;
use App\Service\PaymentService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class TopUpPhoneController extends AbstractController
{
    public Request $request;
    private PaymentService $paymentService;
    private SerializerInterface $serializer;
    protected $em;

    public function __construct(PaymentService $paymentService, SerializerInterface $serializer, EntityManagerInterface $em)
    {
        $this->paymentService = $paymentService;
        $this->serializer = $serializer;
        $this->em = $em;
    }

    /**
     * @Route("/service/payments/{email}/topupphone", name="topupphone", methods={"POST"}, defaults={"subject":"Top Up Phone"})
     * @param $request{'phone_number', 'id_operator', 'amount','cardNumber'}
     * @return JsonResponse
     */

    public function phonePayment(string $email, Request $request) : JsonResponse
    {
        $authorizationHeader = $request->headers->get('Authorization');
        $strForDTO = json_decode($request->getContent(), true);
        $cellPhoneOperators = $this->em->getRepository(CellPhoneOperators::class)->find($strForDTO['id_operator']);
        $strForDTO['subject'] = 'Top Up Phone';
        $strForDTO['headersAuth'] = $authorizationHeader;
        $strForDTO['account_debit'] = $cellPhoneOperators->getAccount();
        $resultDTO = $this->serializer->deserialize(json_encode($strForDTO), RequestDTO::class, 'json');
        $result = $this->paymentService->paymentService($email, $resultDTO);

        return new JsonResponse($result,Response::HTTP_OK);
    }

}