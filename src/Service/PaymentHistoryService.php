<?php

namespace App\Service;

use App\Entity\Payment;

class PaymentHistoryService
{
    public function getFilteredHistoryOfPayments($decodedToken, $request, $doctrine):array
    {
        $matchEmail = $decodedToken->data->email;
        $data = json_decode($request->getContent(), true);
        $data['user_id'] = $matchEmail;

        return $doctrine->getRepository(Payment::class)->findBy($data);
    }
}