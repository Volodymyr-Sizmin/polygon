<?php

namespace App\Tests;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
{
    public function testSpaceRemoval(): void
    {
        $user = new User();
        $user->setFirstName(' Name   ');
        $user->setLastName('        Фамилия');
        $user->setUserName(' User   Name  123  ');
        $this->assertSame('Name', $user->getFirstName());
        $this->assertSame('Фамилия', $user->getLastName());
        $this->assertSame('User Name 123', $user->getUserName());
    }
}
