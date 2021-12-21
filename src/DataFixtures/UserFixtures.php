<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\ResetRequest;
use App\Factory\FileFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserFixtures extends Fixture
{
    /**
     * @var UserPasswordHasherInterface
     */
    private $encoder;

    /**
     * @var FileFactory
     */
    private $fileFactory;

    public function __construct(UserPasswordHasherInterface $encoder, FileFactory $fileFactory)
    {
        $this->fileFactory = $fileFactory;
        $this->encoder = $encoder;
    }

    private function loadMainTestUser(ObjectManager $manager): void
    {
        $user = new User();
        $user->setFirstName('Boris');
        $user->setLastName('Astapau');
        $user->setUserName('b.astapau');
        $user->setEmail('b.astapau@andersenlab.com');
        $user->setPhone('+375291235566');
        $user->setProfilePhoto(FileFactory::createOne()->object());

        $password = $this->encoder->hashPassword($user, 'password');
        $user->setPassword($password);

        $manager->persist($user);
        $manager->flush();
    }

    private function loadVerificationTestUser(ObjectManager $manager): void
    {
        $user = new User();
        $user->setFirstName('need');
        $user->setLastName('verification');
        $user->setUserName('need.verification');
        $user->setEmail('verification@notandersenlab.com');
        $user->setPhone('+375001235566');
        $password = $this->encoder->hashPassword($user, 'password');
        $user->setPassword($password);
        $manager->persist($user);
        $manager->flush();
    }

    private function loadResetTestUser(ObjectManager $manager): void
    {
        $user = new User();
        $user->setFirstName('reset');
        $user->setLastName('password');
        $user->setUserName('reset.password');
        $user->setEmail('password@notandersenlab.com');
        $password = $this->encoder->hashPassword($user, 'password');
        $user->setPassword($password);

        $request = new ResetRequest($user);
        $request->setActivated(true);

        $manager->persist($user);
        $manager->persist($request);
        $manager->flush();
    }

    public function load(ObjectManager $manager): void
    {
        $this->loadMainTestUser($manager);
        //$this->loadVerificationTestUser($manager);
        $this->loadResetTestUser($manager);
    }
}
