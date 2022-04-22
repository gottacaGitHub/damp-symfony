<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;

class   UserFixture extends Fixture
{
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
       $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager): void
    {
         $user = new User();
         $user->setEmail('manager@manager.ru');
         $user->setPassword($this->passwordEncoder->encodePassword($user,'manager'));
         $user->setRoles('ROLE_MANAGER');
         $user->setFIO("Иван Иванович Иванов");
         $user->setIsSuspended(true);
         $manager->persist($user);

        $user = new User();
        $user->setEmail('admin@admin.ru');
        $user->setPassword($this->passwordEncoder->encodePassword($user,'admin1'));
        $user->setRoles('ROLE_ADMIN');
        $user->setFIO("Петр Админович");
        $user->setIsSuspended(true);
        $manager->persist($user);

        $manager->flush();
    }
}
