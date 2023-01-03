<?php

namespace App\Controller;

use App\Entity\Cards;
use App\Entity\User;
use App\Service\CardsInfoService;
use App\Service\TokenService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CardsController extends AbstractController
{
    protected $CardsInfoService;

    public function __construct(CardsInfoService $CardsInfoService)
    {
        $this->CardsInfoService = $CardsInfoService;
    }



    /**
     * @Route("/cards_service/{email}/cards", name="cardslist", methods={"GET"})
     * @param $email
     * @param Response $response
     * @param ManagerRegistry $doctrine
     * @return JsonResponse|void
     */

  ///  public function cardsList(Request $request, Response $response, ManagerRegistry $doctrine)
    public function cardsList(string $email, Response $response, ManagerRegistry $doctrine, Request $request)
    {

        $response = $this->CardsInfoService->getCardsInfo($email);

       // return new Response(, 200);
return $response;
        //списала, показалось нужным

     /*   $session = $request->getSession();
        if ($session->get('attempts') >= 3) {
            return new JsonResponse(
                [
                    'success' => true,
                    'attempts' => 'limit',
                ],
                403
            );
        }*/

      //  $data = json_decode($request->getContent(), true);

       /* if (empty($data['email'])) {
            return new JsonResponse(
                [
                    'success' => false,
                    'body' => [
                        'message' => 'Empty input',
                    ],
                ],
                404
            );
        }*/

      //  $entityManager = $doctrine->getManager();
      //  $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

       /* if (isset($user)) {   //try
            $cards = $entityManager->getRepository(Cards::class)->findOneBy(['client_id' => $user->getId()]);

            if(isset($cards)){
                return new JsonResponse(
                    [
                        'success' => true,
                        'body' => [
                            'balance'=> $cards ->getBalance(),
                            'cardType'=> $cards ->getCardType(),
                            'clientId'=> $cards ->getClientId(),
                            'currency'=> $cards ->getCardCurrency(),
                            'expirationDate'=> $cards ->getExpirationDate(),
                            'id'=> $cards ->getId(),
                            'limit'=> $cards ->getCardLimit(),
                            'name'=> $cards ->getCardName(),
                            'number'=> $cards ->getCardNumber(),
                            'status'=> $cards ->getCardStatus(),

                        ],
                    ],
                    200
                );
            } else {
                return new JsonResponse(
                    [
                        'success' => true,
                        'body' => [ ],
                    ],
                    200
                );
            }

        } else {
            return new JsonResponse(
                [
                    'success' => false,
                    'body' => [
                        'message' => 'Hello. There is not any user to ger card list.',
                    ],
                ],
                200
            );
        }*/


    }
}