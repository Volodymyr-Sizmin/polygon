<?php

namespace App\Service\Interfaces;

use App\Service\TokenService;

interface Authorization
{
    public function getEmailFromHeaderToken(string $authorizationToken): string;
}