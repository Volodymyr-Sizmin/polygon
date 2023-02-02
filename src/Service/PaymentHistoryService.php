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

    public function getHistoryOfPayments($decodedToken, $doctrine):array
    {
        $matchEmail = $decodedToken->data->email;

        $query = " 
        SELECT 
            payments.*,
            currencies.name as currency,   
            payment_statuses.name as status,
            payment_types.name as payment_type  
        FROM 
            payments
        LEFT JOIN 
            currencies ON payments.currency_id = currencies.id
        LEFT JOIN 
            payment_statuses ON payments.status_id = payment_statuses.id
        LEFT JOIN 
            payment_types ON payments.type_id = payment_types.id
        WHERE 
            payments.user_id = :email
        ORDER BY 
            payments.created_at DESC
        LIMIT 1";

        $connection = $doctrine->getConnection("default");
        return $connection
            ->prepare($query)
            ->executeQuery(['email' => $matchEmail])
            ->fetchAllAssociative();
    }

    public function getSortedHistoryOfPayments($decodedToken, $request, $doctrine):array
    {
        $matchEmail = $decodedToken->data->email;
        $data = json_decode($request->getContent(), true);

        if(!$data) {
            $data = [];
        }

        $arraySize = count($data);
        $orderString = "";
        $iterator = 0;

        foreach ($data as $key => $value) {
            $iterator++;
            $orderString = ($iterator == $arraySize) ? $orderString . "payments." . $key . " " . $value . " " : $orderString . "payments." . $key . " " . $value . ", ";
        }

        if($orderString === "") {
            $orderString = "payments.created_at desc ";
        }

        $query ="  
        SELECT 
            payments.*,
            currencies.name as currency,   
            payment_statuses.name as status,
            payment_types.name as payment_type  
        FROM 
            payments
        LEFT JOIN 
            currencies ON payments.currency_id = currencies.id
        LEFT JOIN 
            payment_statuses ON payments.status_id = payment_statuses.id
        LEFT JOIN 
            payment_types ON payments.type_id = payment_types.id
        WHERE 
            payments.user_id = :email
        ORDER BY " . $orderString . "
        LIMIT 1";

        $connection = $doctrine->getConnection("default");
        return $connection
            ->prepare($query)
            ->executeQuery(['email' => $matchEmail])
            ->fetchAllAssociative();
    }
}