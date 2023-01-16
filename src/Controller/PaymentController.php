<?php

namespace App\Controller;

use App\Entity\Payment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;
use Symfony\Component\Serializer\SerializerInterface;

class PaymentController extends AbstractController
{
    /**
     * @Route("/payments_and_transfers/history", name="history", methods={"GET"})
     */
    public function getHistoryOfPayments(ManagerRegistry $managerRegistry, SerializerInterface $serializer): JsonResponse
    {
        //$data = $managerRegistry->getManager()->getRepository(Payment::class)->findAll();
        //!!! mockData for frontend. Development of this code will continue.
        $mockData = [['id' => 1, 'subject' => 'Birthday_gift', 'account_debit_number' => '1111222233334444', 'account_credit_number' => '2222333344445555', 'amount' => 10500, 'currency' => 'GBP', 'user_id' => 1, 'status_id' => 'completed', 'created_at' => date('d.m.Y H:i:s', strtotime('10.01.2023 14:16:29'))],
            ['id' => 2, 'subject' => 'Top_up_phone', 'account_debit_number' => '3333444455556666', 'account_credit_number' => '1111222233334444', 'amount' => 250, 'currency' => 'GBP', 'user_id' => 1, 'status_id' => 'in_processing', 'created_at' => date('d.m.Y H:i:s', strtotime('11.01.2023 10:38:05'))],
            ['id' => 3, 'subject' => 'Some_payment', 'account_debit_number' => '1111222233334444', 'account_credit_number' => '4444555566667777', 'amount' => 1890, 'currency' => 'GBP', 'user_id' => 1, 'status_id' => 'success_failed', 'created_at' => date('d.m.Y H:i:s', strtotime('12.01.2023 16:56:45'))]];
        $result = $serializer->serialize($mockData, 'json');

        return new JsonResponse($result, Response::HTTP_OK, [], true);
    }
}
