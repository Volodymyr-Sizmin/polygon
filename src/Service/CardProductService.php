<?php

namespace App\Service;

use App\Entity\Account;
use App\Entity\Card;
use App\Entity\CardTypes;
use Doctrine\Persistence\ManagerRegistry;
use Faker\Factory;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CardProductService
{
    private  $faker;
    protected TokenService $tokenService;
    protected ManagerRegistry $doctrine;

    public function __construct(TokenService $tokenService, ManagerRegistry $doctrine)
    {
        $this->tokenService = $tokenService;
        $this->doctrine = $doctrine;
        $this->faker = Factory::create();
    }

    public function getCardProducts($token):array
    {
       $this->tokenService->getEmailFromToken($token);

       $cardProduct = $this->doctrine->getRepository(CardTypes::class)->findAll();

//       if (!$cardProduct){
//           throw new \DomainException("Something went wrong ", 500);
//       }
//       foreach ($cardProduct as $value) {
//           if ($value->getCurrency() == 'multi'){
//               $value->setCurrency(CardTypes::CURRENCY['multi']);
//           }else $value->setCurrency(CardTypes::CURRENCY['GBP']);
//
//           $value->setTransferFees(explode('.', $value->getTransferFees()));
//       }
        return $cardProduct;
    }

    public function getCardProduct($token, $id):object
    {
        $this->tokenService->getEmailFromToken($token);

        $cardProduct = $this->doctrine->getRepository(CardTypes::class)->find($id);
        if (!$cardProduct){
            throw new \DomainException("Something went wrong ", 500);
        }

//        if ($cardProduct->getCurrency() == 'multi'){
//            $cardProduct->setCurrency(CardTypes::CURRENCY['multi']);
//        }else $cardProduct->setCurrency(CardTypes::CURRENCY['GBP']);
//
//        $cardProduct->setTransferFees(explode('.', $cardProduct->getTransferFees()));

        return $cardProduct;
    }

    public function applyCard($token, $id, $body):array
    {
        $email = $this->tokenService->getEmailFromToken($token);

        $em = $this->doctrine->getManager();
        $cardProduct = $em->getRepository(CardTypes::class)->find($id);
        if (!$cardProduct) {
            throw new \DomainException("No card found with id  $id ", 404);
        }

        $timestamp = new \DateTimeImmutable();

        $newAccount = new Account();
        $newAccount->setUserId($email);
        $newAccount->setNumber($this->faker->iban('GB'));
        $newAccount->setCurrencyName($body->currency);
        $newAccount->setCreatedAt($timestamp);
        $em->persist($newAccount);
        $em->flush($newAccount);

        $newCard = new Card();
        $expiry = $cardProduct->getCardValidityYears();

        $newCard->setUserId($email);
        $newCard->setCardTypeName($cardProduct->getName());
        $newCard->setNumber($this->faker->creditCardNumber());
        $newCard->setAccountNumber($newAccount->getNumber());
        $newCard->setCurrencyName($body->currency);
        $newCard->setExpiryDate($timestamp->add(new \DateInterval('P'.$expiry.'Y')));
        $newCard->setCreatedAt($timestamp);
        $newCard->setUpdatedAt($timestamp);
        $em->persist($newCard);
        $em->flush($newCard);

        return ['success' => true];
    }
}
