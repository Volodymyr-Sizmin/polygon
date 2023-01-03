<?php

namespace App\Service;


use Doctrine\Persistence\ManagerRegistry;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Contracts\HttpClient\HttpClientInterface;


class CardsInfoService
{
    protected $tokenService;
    private $entityManager;
    private $client;

    public function __construct(TokenService $tokenService, ManagerRegistry $doctrine, HttpClientInterface $client)
    {
        $this->tokenService = $tokenService;
        $this->entityManager = $doctrine->getManager();
        $this->client = $client;
    }

    public function getCardsInfo(string $email): JsonResponse
    {

      //  $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

        $dataEmail      = ['email' => $email];
       /* $dataLifeTime  = ['code_life_time' => 1669646059];
        $dataFirstName  = ['first_name' => $user->getFirstName()];
        $dataLastName   = ['last_name' => $user->getLastName()];

        $dataPassportId = ['passport_id' => $user->getPassportId()];
        $dataResident   = ['resident' => $user->getResident()];
        $dataPassword   = ['password' => $user->getPassword()];
        $dataQuestion   = ['question' => $user->getQuestion()];
        $dataAnswer     = ['answer' => $user->getQuestion()];
*/
        $token = $this->tokenService->createToken(
            $dataEmail,
          //  $dataLifeTime,
           // $dataFirstName,
           // $dataLastName,
           // $dataPassportId,
           // $dataPassword,
           // $dataQuestion,
           // $dataAnswer,
            //$dataResident
        );


        $response = $this->client->request('GET','https://polygon-application.andersenlab.dev/cards_service/'.$email.'/cards',[
            'headers' => [
                'Authorization' => "Bearer $token",
            ],

        ]);

        $content = json_decode($response->getContent());
        $cards = $content->cards;
     //  var_dump($cards) ;


        if(count($cards) > 0){

            $arrCards = array();

            foreach($cards as $card){

                $oneCard = [];
                $oneCard['id'] = $card->id;
                $oneCard['clientId'] = $card->clientId;
                $oneCard['name'] = $card->name;
                $oneCard['number'] = $card->number;
                $oneCard['expirationDate'] = $card->expirationDate;
                $oneCard['balance'] = $card->balance;
                $oneCard['currency'] = $card->currency;
                $oneCard['limit'] = $card->limit;
                $oneCard['status'] = $card->status;
                $oneCard['cardType'] = $card->cardType;
                $oneCard['pinCode'] = $card->pinCode;

            }

            array_push($arrCards, $oneCard);

            return new JsonResponse([
                'success' =>true,
                'body' => [
                    'cards'=>json_encode($arrCards)
                ],
            ], Response::HTTP_OK);
        } else {
            return new JsonResponse([
                'success' => true,
                'message' =>'no cards',

            ], Response::HTTP_NO_CONTENT);
        }

    }
}