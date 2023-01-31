<?php
declare(strict_types=1);

namespace App\Tests\Service;

use App\Tests\ServiceTestCase;

class CardsInfoServiceTest extends ServiceTestCase
{

    public function testGetCardsInfo(): void
    {
        $cardsInfoService = $this->myContainer->get(\App\Service\CardsInfoService::class);
        $response = $cardsInfoService->getCardsInfo('qatest6@gmail.com');
        $this->assertNotEmpty($response);
    }
}