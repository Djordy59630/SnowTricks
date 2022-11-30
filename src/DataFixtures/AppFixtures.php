<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }


    public function load(ObjectManager $manager,): void
    {

        $user = new User();

        $user->setMail('test@test.com');
        $user->setPassword($this->userPasswordHasher->hashPassword($user, 'MonSuperMotDePasse.'));
        $user->setUsername('Michel');
        $user->setRoles(['ROLE_USER']);
        $manager->persist($user);

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 1; // smaller means sooner
    }

}
