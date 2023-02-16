<?php

namespace App\DTO\Transformer;

use App\DTO\RequestDTO;
use Symfony\Component\HttpFoundation\Request;

class RequestTransformerDTO
{
    public function transform(Request $request): RequestDTO
    {
        $dto = new RequestDTO();

        $dto->headersAuth = $request->headers->get('Authorization');
        $dto->amount = $request->get('amount');
        $dto->account_credit = $request->get('account_credit');
        $dto->account_debit = $request->get('account_debit');
        $dto->cardNumber = $request->get('cardNumber');
        $dto->cardNumberRecipient = $request->get('cardNumberRecipient');
        $dto->currency = $request->get('currency');
        $dto->subject = $request->get('subject');

        return $dto;
    }
}
