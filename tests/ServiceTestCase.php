<?php
namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ServiceTestCase extends WebTestCase
{
    protected ContainerInterface $myContainer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->myContainer = static::createClient()->getContainer();
    }
}