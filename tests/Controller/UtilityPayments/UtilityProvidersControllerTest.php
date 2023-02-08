<?php

namespace App\Tests\Controller\UtilityPayments;

use App\Entity\Account;
use App\Entity\UtilitiesProvider;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UtilityProvidersControllerTest extends AbstractUtilityTest
{
    public function testGetAllProviders(): void
    {
        $domCrawler = $this->client->jsonRequest('GET', '/utilities-providers');
        $response = $this->client->getResponse();
        $responseContent = $response->getContent();

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertStringContainsString($this->gasUtilityProvider->getName(), $response);
        $this->assertJson($responseContent);
        $responseArray = json_decode($responseContent, true);
        $this->assertNotEmpty($responseArray);
    }

    public function testGetUtilities(): void
    {
        $this->client->request('GET', '/utilities-providers/utilities');
        $response = $this->client->getResponse();

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertStringContainsString('GAS', $response);
        $responseArray = json_decode($response->getContent(), true);
        $this->assertNotEmpty($responseArray);
    }

    public function testGetByGas(): void
    {
        $this->client->request('GET', '/utilities-providers/by-utility/GAS');
        $response = $this->client->getResponse();

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString($this->gasUtilityProvider->getName(), $response);
        $responseArray = json_decode($response->getContent(), true);
        $this->assertNotEmpty($responseArray);
    }
}
