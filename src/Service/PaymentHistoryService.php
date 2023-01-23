<?php

namespace App\Service;

use App\Entity\Payment;

class PaymentHistoryService
{
    public function getFilteredHistoryOfPayments($decodedToken, $request, $doctrine):array
    {
        $matchEmail = $decodedToken->data->email;
        $data = json_decode($request->getContent(), true);
        $params = ['user_id' => $matchEmail];

        if(isset($data['amount'])) {
            $params['amount'] = $data['amount'];
        }

        if(isset($data['currency'])) {
            $params['currency'] = $data['currency'];
        }

        if(isset($data['created_at'])) {
            $params['created_at'] = $data['created_at'];
        }

        if(isset($data['status_id'])) {
            $params['status_id'] = $data['status_id'];
        }

        if(isset($data['type_id'])) {
            $params['type_id'] = $data['type_id'];
        }

        return $doctrine->getRepository(Payment::class)->findBy($params);
    }
}