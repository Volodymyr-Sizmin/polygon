<?php

namespace App\Service;

use App\DTO\FastPaymentDTO;
use App\Entity\CardTypes;
use App\Entity\Currency;
use App\Entity\FastPayments;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CardProductService
{
    protected TokenService $tokenService;
    protected ManagerRegistry $doctrine;
    protected HttpClientInterface $client;
    const POLYGON_APPLICATION_GO = 'https://polygon-application.andersenlab.dev/';

    public function __construct(HttpClientInterface $client, TokenService $tokenService, ManagerRegistry $doctrine)
    {
        $this->client = $client;
        $this->tokenService = $tokenService;
        $this->doctrine = $doctrine;
    }

    public function getCardProducts(string $token):array
    {
       $this->tokenService->getEmailFromToken($token);

       $cardProduct = $this->doctrine->getRepository(CardTypes::class)->findAll();

       if (!$cardProduct){
           throw new \DomainException("Something went wrong ", 500);
       }
       foreach ($cardProduct as $value) {
           if ($value->getCurrency() == 'multi'){
               $value->setCurrency(CardTypes::CURRENCY['multi']);
           }else $value->setCurrency(CardTypes::CURRENCY['GBP']);

           $value->setTransferFees(explode('.', $value->getTransferFees()));
       }
        return $cardProduct;
    }

    public function getCardProduct(string $token, $id):array
    {
        $this->tokenService->getEmailFromToken($token);

        $cardProduct = $this->doctrine->getRepository(CardTypes::class)->find($id);
        if (!$cardProduct){
            throw new \DomainException("Something went wrong ", 500);
        }

        if ($cardProduct->getCurrency() == 'multi'){
            $cardProduct->setCurrency(CardTypes::CURRENCY['multi']);
        }else $cardProduct->setCurrency(CardTypes::CURRENCY['GBP']);

        $cardProduct->setTransferFees(explode('.', $cardProduct->getTransferFees()));

        return $cardProduct;
    }
}
