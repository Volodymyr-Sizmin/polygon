<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\TokenService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use OpenApi\Annotations as OA;

class SaveNonBankClientDataController extends AbstractController
{
    protected $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    /**
     * @Route("/registration_service/savenondata", name="nondata", methods={"POST"})
     * @OA\Post(
     *     path="/registration_service/savenondata",
     *     tags={"Registration Service"},
     *     description="Save user info",
     *     security={{"Bearer": {}}},
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="password", type="string"),
     *             @OA\Property(property="question", type="string"),
     *             @OA\Property(property="answer", type="string"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Non-bank client data saved",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(
     *                 property="body",
     *                 type="object",
     *                 @OA\Property(property="message", type="string"),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(
     *                 property="body",
     *                 type="object",
     *                 @OA\Property(property="message", type="string"),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(
     *                 property="body",
     *                 type="object",
     *                 @OA\Property(property="message", type="string"),
     *             ),
     *         ),
     *     ),
     * )
     */
    public function savedata(Request $request, ManagerRegistry $doctrine, ValidatorInterface $validatorPass, UserPasswordHasherInterface $passwordHasher): Response
    {
        $data = json_decode($request->getContent(), true);

        $authorizationHeader = $request->headers->get('Authorization');
        $token = $this->tokenService->decodeToken(substr($authorizationHeader, 7));
        $matchEmail = implode(['email' => $token->data->email]);
        $dataIsBankClient = implode(['is_bank_client' => $token->data->is_bank_client]);
        $dataFirst = implode(['first_name' => $token->data->first_name]);
        $dataLast = implode(['last_name' => $token->data->last_name]);
        $dataId = implode(['passport_id' => $token->data->passport_id]);
        $dataResident = implode(['resident' => $token->data->resident]);
        $password = implode(['email' => $token->data->password]);
        $dataQuest = implode(['question' => $token->data->question]);
        $dataAnswer = implode(['answer' => $token->data->answer]);

        $em = $doctrine->getManager();

        if ($dataIsBankClient) {
            $user = $em->getRepository(User::class)->findOneBy(['email' => $matchEmail]);
            $hashedPass = $passwordHasher->hashPassword($user, $password);
            $user->setPassword($hashedPass);
            $user->setQuestion($dataQuest);
            $user->setAnswer($dataAnswer);
        } else {
            $user = new User();

            $errors = $validatorPass->validate($user, null, 'password');

            if (count($errors) > 0) {
                $errorsStringPass = (string) $errors;

                return new JsonResponse(
                    [
                        'success' => false,
                        'body' => [
                            'message' => $errorsStringPass,
                        ],
                    ],
                    Response::HTTP_BAD_REQUEST);
            }

            $hashedPass = $passwordHasher->hashPassword($user, $password);
            $user->setEmail($matchEmail);
            $user->setFirstName($dataFirst);
            $user->setLastName($dataLast);
            $user->setPassportId($dataId);
            $user->setResident($dataResident);
            $user->setPassword($hashedPass);
            $user->setQuestion($dataQuest);
            $user->setAnswer($dataAnswer);
        }
                
        $em->persist($user);
        $em->flush();

        $response = ['success' => true, 'body' => ['message' => ['Data is saved']]];

        return new JsonResponse($response, Response::HTTP_CREATED);
    }
}
