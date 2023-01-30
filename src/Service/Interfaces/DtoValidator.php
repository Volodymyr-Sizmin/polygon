<?php

namespace App\Service\Interfaces;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

interface DtoValidator
{
    /**
     * @param object $dto
     * @return void
     * @throws BadRequestHttpException
     */
    public function validateDto(object $dto): void;

}