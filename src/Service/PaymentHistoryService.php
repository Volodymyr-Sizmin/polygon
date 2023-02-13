<?php

namespace App\Service;

use App\Entity\Payment;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

class PaymentHistoryService
{
    public function getFilteredHistoryOfPayments(\stdClass $decodedToken, Request $request, ManagerRegistry $doctrine):array
    {
        $matchEmail = $decodedToken->data->email;
        $data = json_decode($request->getContent(), true);

        //parameters data : amount, created_at, currency, status, payment_type
        if(!array_key_exists('params', $data)) {
            $paramsData = [];
        } else {
            $paramsData = $data['params'];
        }

        $arrayParamsSize = count($paramsData);
        $paramsString = "";
        $iterator = 0;
        $parameters = [];

        foreach ($paramsData as $params) {
            $iterator++;

            $tableName = "payments.";
            $paramNameLeft = $params['name'];
            $paramNameRight = $params['name'];

            if($params['name'] == 'currency') {
                $tableName = "currencies.name";
                $paramNameLeft = "";
                $paramNameRight = "currency";
            } elseif ($params['name'] == 'status') {
                $tableName = "payment_statuses.name";
                $paramNameLeft = "";
                $paramNameRight = "status";
            } elseif ($params['name'] == 'payment_type') {
                $tableName = "payment_types.name";
                $paramNameLeft = "";
                $paramNameRight = "payment_type";
            }

            if ($params['name'] == 'amountFrom' or $params['name'] == 'amountTo') {
                $parameters[$params['name']] = (int) $params['value'];

                if (array_key_exists('amountFrom', $parameters) and array_key_exists('amountTo', $parameters)) {
                    $paramsString = ($iterator == $arrayParamsSize) ? $paramsString . $tableName . "amount" . " BETWEEN " . ':amountFrom' . " AND " . ':amountTo' :
                        $paramsString . $tableName . "amount" . " BETWEEN " . ':amountFrom' . " AND " . ':amountTo' . " AND ";
                }

            } elseif ($params['name'] == 'createdFrom' or $params['name'] == 'createdTo') {
                $parameters[$params['name']] = $params['value'];

                if (array_key_exists('createdFrom', $parameters) and array_key_exists('createdTo', $parameters)) {
                    $paramsString = ($iterator == $arrayParamsSize) ? $paramsString . $tableName . "created_at" . " BETWEEN " . ':createdFrom' . " AND " . ':createdTo' :
                        $paramsString . $tableName . "created_at" . " BETWEEN " . ':createdFrom' . " AND " . ':createdTo' . " AND ";
                }

            } else {
                $parameters[$params['name']] = $params['value'];
                $paramsString = ($iterator == $arrayParamsSize) ? $paramsString . $tableName . $paramNameLeft . $params['sign'] . ":" . $paramNameRight :
                    $paramsString . $tableName . $paramNameLeft . $params['sign'] . ":" . $paramNameRight . " AND ";
            }
        }

        $paramsString = ($paramsString) ? $paramsString . " AND payments.user_id = :email" : $paramsString . " payments.user_id = :email";
        $parameters['email'] = $matchEmail;

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
        WHERE " . $paramsString ."";

        return $doctrine
            ->getConnection("default")
            ->prepare($query)
            ->executeQuery($parameters)
            ->fetchAllAssociative();
    }

    public function getHistoryOfPayments(\stdClass $decodedToken, ManagerRegistry $doctrine):array
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
        LIMIT 10";

        $connection = $doctrine->getConnection("default");
        return $connection
            ->prepare($query)
            ->executeQuery(['email' => $matchEmail])
            ->fetchAllAssociative();
    }

    public function getSortedHistoryOfPayments(\stdClass $decodedToken, Request $request, ManagerRegistry $doctrine):array
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
        LIMIT 10";

        $connection = $doctrine->getConnection("default");
        return $connection
            ->prepare($query)
            ->executeQuery(['email' => $matchEmail])
            ->fetchAllAssociative();
    }

    public function getPaginatedHistoryOfPayments(\stdClass $decodedToken, Request $request, ManagerRegistry $doctrine):array
    {
        $matchEmail = $decodedToken->data->email;
        $data = json_decode($request->getContent(), true);

        //sort data : subject, created_at, amount
        $orderString = "payments.created_at desc ";

        if(array_key_exists('sort', $data)) {
            $sortData = $data['sort'];
            if(count($sortData) > 0) {

                $arraySortSize = count($sortData[0]);
                $orderString = "";
                $iterator = 0;

                foreach ($sortData[0] as $key => $value) {
                    $iterator++;
                    $orderString = ($iterator == $arraySortSize) ? $orderString . "payments." . $key . " " . $value . " " : $orderString . "payments." . $key . " " . $value . ", ";
                }
            }
        }

        //parameters data : amount, created_at, currency, status, payment_type
        if(!array_key_exists('params', $data)) {
            $paramsData = [];
        } else {
            $paramsData = $data['params'];
        }

        $arrayParamsSize = count($paramsData);
        $paramsString = "";
        $iterator = 0;
        $parameters = [];

        foreach ($paramsData as $params) {
            $iterator++;

            $tableName = "payments.";
            $paramNameLeft = $params['name'];
            $paramNameRight = $params['name'];

            if($params['name'] == 'currency') {
                $tableName = "currencies.name";
                $paramNameLeft = "";
                $paramNameRight = "currency";
            } elseif ($params['name'] == 'status') {
                $tableName = "payment_statuses.name";
                $paramNameLeft = "";
                $paramNameRight = "status";
            } elseif ($params['name'] == 'payment_type') {
                $tableName = "payment_types.name";
                $paramNameLeft = "";
                $paramNameRight = "payment_type";
            }

            if ($params['name'] == 'amountFrom' or $params['name'] == 'amountTo') {
                $parameters[$params['name']] = (int) $params['value'];

                if (array_key_exists('amountFrom', $parameters) and array_key_exists('amountTo', $parameters)) {
                    $paramsString = ($iterator == $arrayParamsSize) ? $paramsString . $tableName . "amount" . " BETWEEN " . ':amountFrom' . " AND " . ':amountTo' :
                        $paramsString . $tableName . "amount" . " BETWEEN " . ':amountFrom' . " AND " . ':amountTo' . " AND ";
                }

            } elseif ($params['name'] == 'createdFrom' or $params['name'] == 'createdTo') {
                $parameters[$params['name']] = $params['value'];

                if (array_key_exists('createdFrom', $parameters) and array_key_exists('createdTo', $parameters)) {
                    $paramsString = ($iterator == $arrayParamsSize) ? $paramsString . $tableName . "created_at" . " BETWEEN " . ':createdFrom' . " AND " . ':createdTo' :
                        $paramsString . $tableName . "created_at" . " BETWEEN " . ':createdFrom' . " AND " . ':createdTo' . " AND ";
                }

            } else {
                $parameters[$params['name']] = $params['value'];
                $paramsString = ($iterator == $arrayParamsSize) ? $paramsString . $tableName . $paramNameLeft . $params['sign'] . ":" . $paramNameRight :
                    $paramsString . $tableName . $paramNameLeft . $params['sign'] . ":" . $paramNameRight . " AND ";
            }
        }
        //dd($paramsString);
        $paramsString = ($paramsString) ? $paramsString . " AND payments.user_id = :email" : $paramsString . " payments.user_id = :email";
        $parameters['email'] = $matchEmail;

        //offset and limit  data
        $offsetLimitString = "";
        $offsetLimitData = $data['page'];

        if(!array_key_exists('page', $data)) {
            $offsetLimitData = [];
        }

        $limit = 10;
        if(array_key_exists('limit',$offsetLimitData[0])) {
            $limit = $offsetLimitData[0]['limit'];
            $offsetLimitString = "LIMIT " . $offsetLimitData[0]['limit'];
        }

        $pageNumber = 1;
        if(array_key_exists('page_number',$offsetLimitData[0])) {
            $pageNumber = $offsetLimitData[0]['page_number'];
            $offsetLimitString = $offsetLimitString . " OFFSET " . ($pageNumber - 1) * $limit;
        }

        if($offsetLimitString === "") {
            $offsetLimitString = "LIMIT 10";
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
        WHERE " . $paramsString ." 
        ORDER BY " . $orderString . $offsetLimitString ."";

        $queryResult = $doctrine
            ->getConnection("default")
            ->prepare($query)
            ->executeQuery($parameters)
            ->fetchAllAssociative();

        $fullResult = $this->getFilteredHistoryOfPayments($decodedToken, $request, $doctrine);
        $allValuesQty = count($fullResult);
        $someValuesQty = count($queryResult);
        $totalPages = (int) ceil($allValuesQty / ($limit > 0 ? $limit : 1));

        $result['content'] = $queryResult;
        $result['pageNumber'] = $pageNumber;
        $result['last'] = ($pageNumber == $totalPages);
        $result['first'] = $totalPages && ($pageNumber == 1);
        $result['totalPages'] =  $totalPages;
        $result['totalElements'] = $allValuesQty;
        $result['numberOfElements'] = $someValuesQty;
        $result['empty'] = !$someValuesQty;

        return $result;
    }
}