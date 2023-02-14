<?php

namespace App\Controller;

use App\DTO\ChangePinDTO;
use App\Service\CardsInfoService;
use App\Service\Interfaces\CardsOperations;
use App\Service\Interfaces\DtoValidator;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CardsController extends AbstractController
{
    protected CardsInfoService $cardsInfoService;
    protected SerializerInterface $serializer;
    protected DtoValidator $validator;

    public function __construct(
        CardsInfoService $cardsInfoService,
        SerializerInterface $serializer,
        DtoValidator $validator)
    {
        $this->cardsInfoService = $cardsInfoService;
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * @Route("/payments_and_transfers/{email}/cards", name="cardslist", methods={"GET"})
     *
     * @return JsonResponse|void
     */
    public function cardsList(string $email): JsonResponse
    {
        $response = $this->cardsInfoService->getCardsInfo($email);

        return count($response) > 0 ? new JsonResponse(['success' => true, 'cards' => $response], Response::HTTP_OK) : new JsonResponse(['success' => true], Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route ("/cards/change-pin", name="change pin", methods={"PUT"})
     */
    public function changePin(Request $request, UserService $userService, CardsOperations $cardsOperationsService): JsonResponse
    {
        $goToken = $request->headers->get('authorization') ?? '';
        $changePinDto = $this->serializer->deserialize(
            $request->getContent(),
            ChangePinDTO::class,
            'json'
        );
        /* @var ChangePinDTO $changePinDto */
        $this->validator->validateDto($changePinDto);
        $userService->assertSecretAnswerValid($changePinDto->questionAnswer, $goToken);
        $cardsOperationsService->changePin($changePinDto, $goToken);

        return $this->json(['success' => 'true']);
    }
}
