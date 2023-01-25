<?php

namespace App\DTO\Transformer;

use App\DTO\RequestPaymentDTO;
use Symfony\Component\HttpFoundation\Request;

class RequestPaymentTransformerDTO
{
    public function transform(Request $request): RequestPaymentDTO
    {
        $dto = new RequestPaymentDTO();

        $dto->setHeadersAuth($request->headers->get('Authorization')) ;
        $dto->setAmount($request->get('amount'));
        $dto->setAccountCredit($request->get('account_credit')) ;
        $dto->setAccountDebit($request->get('account_debit'));
        $dto->setCardNumber($request->get('cardNumber'));
        $dto->setCardNumberRecipient($request->get('cardNumberRecipient'));
        $dto->setCurrency($request->get('currency'));
        $dto->setSubject($request->get('subject'));

        return $dto;
    }
}
