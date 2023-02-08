<?php

namespace App\Tests\Controller;

use App\Service\PaymentHistoryService;
use App\Service\TokenService;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PaymentHistoryServiceTest extends WebTestCase
{
    protected KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    /**
     * @dataProvider userPaymentProvider
     */
    public function testFilterHistoryOfPayments(): void
    {
        //$container = self::bootKernel();
        /*
        // (1) boot the Symfony kernel
        self::bootKernel();

        // (2) use static::getContainer() to access the service container
        $container = static::getContainer();

        $newsRepository = $this->createMock(TokenService::class);
        $newsRepository->expects(self::once())
            ->method('decodeToken')
            ->willReturn([
                new \stdClass(),
                new News('some other news'),
            ])
        ;

        // the following line won't work unless the alias is made public
        $container->set(NewsRepositoryInterface::class, $newsRepository);

        // will be injected the mocked repository
        $newsletterGenerator = $container->get(NewsletterGenerator::class);
        */

        $this->client->jsonRequest('GET', '/payments_and_transfers/filter_history');
        $response = $this->client->getResponse();
        $this->assertSame(200, $response->getStatusCode());

        $responseData = json_decode($response->getContent());
        $this->assertSame([], $responseData);
    }

    public function userPaymentProvider(): array
    {
        $faker = Factory::create();
        return [
            [
                ['amount' => 78, 'status_id' => 3], 201
            ]
        ];
    }
}