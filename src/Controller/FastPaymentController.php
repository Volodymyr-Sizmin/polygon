<?php

namespace App\Controller;

use App\DTO\Transformer\FastPaymentTransformerDTO;
use App\Service\CardBalanceService;
use App\Service\FastPaymentService;
use App\Service\TokenService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class FastPaymentController extends AbstractController
{
    protected FastPaymentService $fastPaymentService;
    protected SerializerInterface $serializer;

    public function __construct(FastPaymentService $fastPaymentService, SerializerInterface $serializer)
    {
        $this->fastPaymentService = $fastPaymentService;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/payments_and_transfers/fast_payments", name="fast_payments", methods={"GET"})
     */
    public function getFastPayments(Request $request): JsonResponse
    {
        try{
            $dto = FastPaymentTransformerDTO::transformerDTO($request);
            $fast_payments = $this->fastPaymentService->getFastPayments($dto);
            $result = $this->serializer->serialize($fast_payments, 'json');
            return new JsonResponse($result, Response::HTTP_OK, [], true );
        } catch (\Exception $e){
            return new JsonResponse(
                [
                    'success' => false,
                    'body' => [
                        'exception' => get_class($e),
                        'message' => $e->getMessage(),
                        'status' => $e->getCode(),
                    ],
                ],
                $e->getCode());
        }
    }

    /**
     * @Route("/payments_and_transfers/fast_payments/{id}", name="fast_payment", methods={"GET"})
     */
    public function getFastPaymentInfo(int $id, Request $request, CardBalanceService $balanceService): JsonResponse
    {
        try{
            $dto = FastPaymentTransformerDTO::transformerDTO($request, $id);
            $fastPayment = $this->fastPaymentService->getFastPaymentInfo($dto);
            $cards = $balanceService->showCards($request);
            $result = $this->serializer->serialize([$fastPayment, $cards],  'json');
            return new JsonResponse($result, Response::HTTP_OK, [], true );

        }catch (\Exception $e){
        return new JsonResponse(
            [
                'success' => false,
                'body' => [
                    'exception' => get_class($e),
                    'message' => $e->getMessage(),
                    'status' => $e->getCode(),
                ],
            ],
            $e->getCode());
        }
    }

    /**
     * @Route("/payments_and_transfers/fast_payments/{id}", name="edit_payment", methods={"PUT"})
     */
    public function updateTemplate(int $id, Request $request):JsonResponse
    {
        try{
            $dto = FastPaymentTransformerDTO::transformerDTO($request, $id);
            $fast_payment = $this->fastPaymentService->updateFastPayment($dto);
            $result = $this->serializer->serialize($fast_payment, 'json');
            return new JsonResponse($result, Response::HTTP_OK, [], true );
        }catch (\Exception $e){
            return new JsonResponse(
                [
                    'success' => false,
                    'body' => [
                        'exception' => get_class($e),
                        'message' => $e->getMessage(),
                        'status' => $e->getCode(),
                    ],
                ],
                $e->getCode());
        }
    }

    /**
     * @Route("/payments_and_transfers/fast_payments/{id}", name="templates_delete", methods={"DELETE"})
     */
    public function deleteTemplate(int $id, Request $request):JsonResponse
    {
        try{
            $dto = FastPaymentTransformerDTO::transformerDTO($request, $id);
            $fast_payment = $this->fastPaymentService->deleteTemplate($dto);
            $result = $this->serializer->serialize($fast_payment, 'json');
            return new JsonResponse($result, Response::HTTP_OK, [], true );
        }catch (\Exception $e) {
            return new JsonResponse(
                [
                    'success' => false,
                    'body' => [
                        'exception' => get_class($e),
                        'message' => $e->getMessage(),
                        'status' => $e->getCode(),
                    ],
                ],
                $e->getCode());
        }
    }

    /**
     * @Route("/payments_and_transfers/fast_payments/{id}", name="making_payment", methods={"POST"})
     */
    public function makePayment(int $id, Request $request, TokenService $tokenService)
    {
        try{
            $dto = FastPaymentTransformerDTO::transformerDTO($request, $id);
            $fastPayment = $this->fastPaymentService->getFastPaymentInfo($dto);
            $dto->amount = $fastPayment->getAmount();
            $dto->cardNumber = $fastPayment->getCardNumber();
            $email = $fastPayment->getUserEmail();
            $this->fastPaymentService->updateBalance($dto, $email);

            return new JsonResponse(
                [
                    'success' => true,
                    'body' => [
                        'message' => 'Payment successful',
                    ],
                ],
                200);
        }catch (\Exception $e){
            return new JsonResponse(
                [
                    'success' => false,
                    'body' => [
                        'exception' => get_class($e),
                        'message' => $e->getMessage(),
                        'status' => $e->getCode(),
                    ],
                ],
                $e->getCode());
        }
    }
}
