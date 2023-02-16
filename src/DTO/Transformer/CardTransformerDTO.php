<?php

namespace App\DTO\Transformer;

use App\DTO\CardDTO;

class CardTransformerDTO
{
    public function transformOneCard(array $cardsArray): CardDTO
    {
        $dto = new CardDTO();

        $dto->setId($cardsArray['id']);

        $dto->setBalance($cardsArray['balance']);

        $dto->setUserId($cardsArray['user_id']);

        $dto->setName($cardsArray['name']);

        $dto->setCardTypeName($cardsArray['card_type_name']);

        $dto->setNumber($cardsArray['number']);

        $dto->setAccountNumber($cardsArray['account_number']);

        $dto->setCurrencyName($cardsArray['currency_name']);

        $dto->setTransactionLimit($cardsArray['transaction_limit'] ?? 'null');

        $dto->setCreditLimit($cardsArray['credit_limit'] ?? 'null');

        $dto->setStatus($cardsArray['status']);

        $dto->setPinCode($cardsArray['pin_code']);

        $dto->setAnswerAttempts($cardsArray['answer_attempts']);

        $dto->setExpiryDate($cardsArray['expiry_date']);

        $dto->setCreatedAt($cardsArray['created_at']);

        $dto->setUpdatedAt($cardsArray['updated_at']);

        if (isset($cardsArray['first_name']) && isset($cardsArray['last_name'])) {

            $dto->setFirstName($cardsArray['first_name'] ?? 'null');

            $dto->setLastName($cardsArray['last_name'] ?? 'null');
        }
        return $dto;
    }

    public function transformCards(array $cardsArray): array
    {
        $dto = [];

        foreach ($cardsArray as $card) {
            $dto[] = $this->transformOneCard($card);
        }

        return $dto;
    }
}