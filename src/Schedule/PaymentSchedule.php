<?php

namespace App\Schedule;

use App\Entity\Autopayments;
use App\Service\CardBalanceService;
use Doctrine\Persistence\ManagerRegistry;
use Zenstruck\ScheduleBundle\Schedule;
use Zenstruck\ScheduleBundle\Schedule\ScheduleBuilder;

class PaymentSchedule implements ScheduleBuilder
{
    public $doctrine;
    public $cardBalanceService;

    public function __construct(ManagerRegistry $doctrine, CardBalanceService $cardBalanceService)
    {
        $this->doctrine = $doctrine;
        $this->cardBalanceService = $cardBalanceService;
    }

    public function buildSchedule(Schedule $schedule): void
    {
        $schedule->timezone('UTC');
        $em = $this->doctrine->getManager();
        $autopaymentsWeekly = $em->getRepository(Autopayments::class)->findOneBy(['payments_period' => 'once a week']);
        $autopaymentsMonthly = $em->getRepository(Autopayments::class)->findOneBy(['payments_period' => 'once a months']);
        $autopaymentsTwiceMonth = $em->getRepository(Autopayments::class)->findOneBy(['payments_period' => 'twice a months']);

        $schedule->addCallback(function () use ($autopaymentsWeekly) {
            $this->cardBalanceService->processAutopayment($autopaymentsWeekly);
        })->description('Processing autopayment weekly')->weekly()->at(1);

        $schedule->addCallback(function () use ($autopaymentsMonthly) {
            $this->cardBalanceService->processAutopayment($autopaymentsMonthly);
        })->description('Processing autopayment once a months')->monthly()->at(1);

        $schedule->addCallback(function () use ($autopaymentsTwiceMonth) {
            $this->cardBalanceService->processAutopayment($autopaymentsTwiceMonth);
        })->description('Processing autopayment twice a months')->twiceMonthly()->at(1);
    }
}