<?php

namespace App\Controller;

use App\DTO\Transformer\FastPaymentTransformerDTO;
use App\Entity\CardTypes;
use App\Entity\FastPayments;
use App\Repository\CardTypesRepository;
use App\Service\CardProductService;
use App\Service\FastPaymentService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CardProductController extends AbstractController
{
    protected CardProductService $cardProductService;
    protected SerializerInterface $serializer;

    public function __construct(CardProductService $cardProductService,  SerializerInterface $serializer)
    {
        $this->cardProductService = $cardProductService;
        $this->serializer = $serializer;
    }


    /**
     * @Route("/card_products", name="card_products",  methods={"GET"})
     */
    public function getCardProducts(Request $request):JsonResponse
    {
        try{
            $token = $request->headers->get('Authorization');
            $cardProduct = $this->cardProductService->getCardProducts($token);

            $result = $this->serializer->serialize($cardProduct, 'json');
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
     * @Route("/card_products/{id}", name="card_product",  methods={"GET"})
     */
    public function getCardProduct(Request $request, int $id):JsonResponse
    {
        try{
            $token = $request->headers->get('Authorization');
            $cardProduct = $this->cardProductService->getCardProduct($token, $id);
            $result = $this->serializer->serialize($cardProduct, 'json');
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
     * @Route("/card_products/{id}", name="apply_card",  methods={"PUT"})
     */
    public function applyCard(Request $request, $id):JsonResponse
    {
        try{
            $token = $request->headers->get('Authorization');
            $body = json_decode($request->getContent());
            $newCard = $this->cardProductService->applyCard($token, $id, $body);
            $result = $this->serializer->serialize($newCard, 'json');
            return new JsonResponse($result, Response::HTTP_OK, [], true );

        } catch (\Exception $e) {
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
