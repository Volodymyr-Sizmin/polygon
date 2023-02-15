<?php

namespace App\Controller;

use App\DTO\ChangePinDTO;
use App\Service\CardsInfoService;
use App\Service\CheckAuthService;
use Doctrine\ORM\EntityManagerInterface;
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
    protected EntityManagerInterface $em;
    protected SerializerInterface $serializer;
    protected CardsInfoService $cardsInfoService;
    protected DtoValidator $validator;
    protected CheckAuthService $checkAuth;

    public function __construct(
        EntityManagerInterface $em,
        SerializerInterface $serializer,
        CardsInfoService $cardsInfoService,
        DtoValidator $validator,
        CheckAuthService $checkAuth)
    {
        $this->em = $em;
        $this->serializer = $serializer;
        $this->cardsInfoService = $cardsInfoService;
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->checkAuth = $checkAuth;
    }

    /**
     * @Route("/{email}/cards", name="usersCardslist", methods={"GET"})
     * @param string $email
     * @return JsonResponse|void
     */
    public function cardsList(string $email, Request $request): JsonResponse
    {

        try {
            $authorizationHeader = $request->headers->get('Authorization');
            $this->checkAuth->checkAuthentication($email, $authorizationHeader);
            $result = $this->cardsInfoService->getCardsWithBalance($email);

            return new JsonResponse(['success' => true, 'cards' => $result], Response::HTTP_OK);
        } catch (\Exception $e) {
            return new JsonResponse(
                [
                    'success' => false,
                    'body' => [
                        'exception' => get_class($e),
                        'message' => $e->getMessage(),
                        'status' => $e->getCode(),
                        'line' => $e->getLine(),
                        'file' => $e->getFile(),
                    ],
                ],
                $e->getCode());
        }
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
