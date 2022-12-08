<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Cookie;

class CookieService
{
    public function setCookie($value)
    {
        return new Cookie('UserCookie', $value, time() + 600, '/', null, false, false, false, 'lax');
    }
}