<?php

namespace App\Tests;

use App\Entity\Playlist;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
{
    private $user;

    public function setUp(): void
    {
        $this->user = new User();
    }

    public function testSpaceRemoval(): void
    {
        $this->user->setFirstName(' Name   ');
        $this->user->setLastName('        Фамилия');
        $this->user->setUserName(' User   Name  123  ');
        $this->assertSame('Name', $this->user->getFirstName());
        $this->assertSame('Фамилия', $this->user->getLastName());
        $this->assertSame('User Name 123', $this->user->getUserName());
    }

    public function testActionsWithUserRoles()
    {
        $roles = $this->user->getRoles();
        $this->assertIsArray($roles);

        $this->user->setRoles(['ROLE_TESTUSER', 'ROLE_TESTADMIN']);
        $roles = $this->user->getRoles();
        $this->assertContains('ROLE_TESTUSER', $roles);
        $this->assertContains('ROLE_TESTADMIN', $roles);

        $this->user->addRole('ROLE_TESTMODERATOR');
        $this->assertContains('ROLE_TESTMODERATOR', $this->user->getRoles());

        $this->user->removeRole('ROLE_TESTUSER');
        $this->assertNotContains('ROLE_TESTUSER', $this->user->getRoles());
    }

    public function testActionsWithPlaylist()
    {
        $collection = $this->user->getPlaylists();
        $this->assertInstanceOf('Doctrine\Common\Collections\ArrayCollection', $collection);

        $playlist = new Playlist();

        $this->user->addPlaylist($playlist);
        $this->assertTrue($collection->contains($playlist));

        $this->user->removePlaylist($playlist);
        $this->assertFalse($collection->contains($playlist));
    }
}
