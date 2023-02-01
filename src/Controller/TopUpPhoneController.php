<?php
namespace App\Controller;

use App\DTO\RequestPaymentDTO;
use App\Entity\Account;
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
    protected Request $request;
    protected PaymentService $paymentService;
    protected SerializerInterface $serializer;
    protected $em;

    public function __construct(PaymentService $paymentService, SerializerInterface $serializer, EntityManagerInterface $em)
    {
        $this->paymentService = $paymentService;
        $this->serializer = $serializer;
        $this->em = $em;
    }

    /**
     * @Route("/service/payments/{email}/topupphone", name="topupphone", methods={"POST"}, defaults={"subject":"Top Up Phone"})
     * @param $request{'phone_number', 'id_operator', 'amount','cardNumber', 'subject'}
     * @return JsonResponse
     */

    public function phonePayment(string $email, Request $request, EntityManagerInterface $em) : JsonResponse
    {
        define("App\Controller\NAME", 'Top Up Phone');

        try {
            $authorizationHeader = $request->headers->get('Authorization');
            $strForDTO = json_decode($request->getContent(), true);
            $cardNumber = $strForDTO['cardNumber'];
            $account_credit = $em->getRepository(Account::class)->findOneBy(['cardNumber' => $cardNumber])->getNumber();
            $cellPhoneOperators = $this->em->getRepository(CellPhoneOperators::class)->find($strForDTO['id_operator']);
            $strForDTO['account_debit'] = $cellPhoneOperators->getAccount();
            $strForDTO['name'] = NAME;
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





        return new JsonResponse($result,Response::HTTP_OK);
    }
}