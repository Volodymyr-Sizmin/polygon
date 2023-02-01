<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PaymentByCardNumberControllerTest extends WebTestCase
{
    protected KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function testPaymentByCardNumber(): void
    {
        $headers = ['content-Type' => 'application/json', 'accept' => 'application/json', 'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJhZG1pbkBwb2x5YmFuay5jb20iLCJleHAiOjE3Njk2NDcyNTksImlhdCI6MTY2OTY0NTQ1OSwiYXVkIjoicWF0ZXN0NkBnbWFpbC5jb20iLCJyb2xlIjoiUk9MRV9VU0VSIiwiZGF0YSI6eyJjb2RlX2xpZmVfdGltZSI6MTY2OTY0NjA1OSwiZmlyc3RfbmFtZSI6Ik1pbmEiLCJsYXN0X25hbWUiOiJIYXJja2VyIiwicGFzc3BvcnRfaWQiOiIxMzQxMzVEIiwicmVzaWRlbnQiOjEsInBhc3N3b3JkIjoiVXNlcjEyMzQhIiwicXVlc3Rpb24iOiJXaGF0J3MgdGhlIG5hbWUgb2YgeW91ciBmaXJzdCBwZXQ_IiwiYW5zd2VyIjoiQnVsYmFzYXVyIn19.NYFLLt_KKv9ZTDmP6IcdhI9rTEOwOE_q9fOpaB6NV40'];
        $bodyJson = [
            'cardNumber' => '4404667100430123',
            'amount' => '10',
            'cardNumberRecipient' => '4404667100430123',
            'currencyId' => '1'
        ];
        $this->client->jsonRequest('POST', '/service/payments/qatest6@gmail.com/bycardnumber', $bodyJson, $headers);
        $response = $this->client->getResponse();
        $this->assertSame(200, $response->getStatusCode());

        $responseData = json_decode($response->getContent());
        $this->assertSame([], $responseData);
    }
}