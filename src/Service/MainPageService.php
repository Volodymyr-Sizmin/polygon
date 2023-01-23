<?php

namespace App\Service;

use App\Entity\PaymentType;
//use Symfony\Contracts\HttpClient\HttpClientInterface;
use Doctrine\Persistence\ManagerRegistry;

class MainPageService
{
    protected ManagerRegistry $managerRegistry;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    public function getFastPaymentsList(): array
    {
        //return $managerRegistry->getManager()->getRepository(FastPayment::class)->findAll();

        $connection = $this->managerRegistry->getConnection("default");
        return $connection
            ->prepare("SELECT * FROM fast_payments")
            ->executeQuery()
            ->fetchAllAssociative()
        ;
    }

    public function getAutoPaymentsList(): array
    {
        //return $managerRegistry->getManager()->getRepository(AutoPayments::class)->findAll();

        $connection = $this->managerRegistry->getConnection("default");
        return $connection
            ->prepare("SELECT * FROM autopayments")
            ->executeQuery()
            ->fetchAllAssociative()
            ;
    }

    public function getPaymentTypeList(): array
    {
        return $this->managerRegistry->getManager()->getRepository(PaymentType::class)->findBy(['on_the_main_page' => 1]);
    }
}