<?php

namespace App\Controller;

use App\DTO\UtilityPaymentByCardDTO;
use App\DTO\UtilityPaymentDTO;
use App\Helpers\ValidationHelper;
use App\Service\Interfaces\DtoValidator;
use App\Service\Interfaces\UtilityPayment;
use App\Service\TokenService;
use App\Service\UtilityPaymentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class UtilityPaymentsController extends AbstractController
{
    private SerializerInterface $serializer;
    private DtoValidator $validator;
    private UtilityPayment $utilityPayment;

    public function __construct(
        SerializerInterface $serializer,
        DtoValidator $validator,
        UtilityPayment $utilityPayment
    ) {
        $this->utilityPayment = $utilityPayment;
        $this->serializer = $serializer;
        $this->validator = $validator;
    }
    /**
     * @Route("/utilities/pay", name="utility_payments_pay", methods={"POST"})
     */
    public function pay(Request $request): Response
    {
        $token = $request->headers->get('authorization');
        $dto = $this->serializer->deserialize(
            $request->getContent(),
            UtilityPaymentDTO::class,
            'json'
        );
        /**@var UtilityPaymentDTO $dto*/
        $this->validator->validateDto($dto);
        $this->utilityPayment->pay($dto, $token);

        return $this->json(['success' => 'true']);
    }
}
