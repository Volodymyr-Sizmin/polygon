<?php

namespace App\Service\Interfaces;

interface Authorization
{
    public function getEmailFromHeaderToken(string $authorizationToken): string;
}
