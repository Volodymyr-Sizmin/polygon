<?php

namespace App\Service;

use App\Entity\PaymentType;
use Doctrine\Persistence\ManagerRegistry;

class MainPageService
{
    protected ManagerRegistry $managerRegistry;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    public function getPaymentTypeList(): array
    {
        return $this->managerRegistry->getManager()->getRepository(PaymentType::class)->findBy(['on_the_main_page' => 1]);
    }
}