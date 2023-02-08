<?php

namespace App\Service;

use App\Service\Interfaces\DtoValidator;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DtoValidatorService implements DtoValidator
{
    private ValidatorInterface $validator;
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }
    /**
     * @inheritDoc
     */
    public function validateDto(object $dto): void
    {
        $errors = $this->validator->validate($dto);
        if (count($errors) > 0) {
            $errorMessage = $this->makeMessageFromErrors($errors);
            throw new BadRequestHttpException($errorMessage, null, 400);
        }
    }

    private function makeMessageFromErrors(ConstraintViolationListInterface $errors): string
    {
        $errorMessage = '';
        foreach ($errors as $error) {
            /**@var ConstraintViolationInterface $error*/
            $errorMessage .= 'Validation error in property: '
                . $error->getPropertyPath() . ' '
                . $error->getMessage();
        }

        return $errorMessage;
    }
}