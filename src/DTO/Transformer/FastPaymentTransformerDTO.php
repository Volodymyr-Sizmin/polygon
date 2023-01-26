<?php

namespace App\DTO\Transformer;

use App\DTO\FastPaymentDTO;
use Symfony\Component\HttpFoundation\Request;

class FastPaymentTransformerDTO
{
    /**
     * @throws \App\Exception\ValidationServiceException
     */
    public static function transformerDTO(Request $request,  int $id=0): FastPaymentDTO
    {
        $body = json_decode($request->getContent());
        $dto = new FastPaymentDTO();
        $dto->token = $request->headers->get('Authorization');
        $dto->name = $body->name ?? null;
        $dto->cardNumber = $body->card_number ?? null;
        $dto->paymentReason = $body->payment_reason ?? null;
        $dto->amount = $body->amount ?? null;
        $dto->accountNumber = $body->account_number ?? null;
        $dto->address = $body->address ?? null;
        $dto->recepientName = $body->recepient_name ?? null;
        $dto->templateId = $id;

        return $dto;
    }
}
