<?php

declare(strict_types = 1);

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    const ADMIN_USERNAME = 'admin';
    const ADMIN_PASSWORD = 'admin123';

    public function load(ObjectManager $manager)
    {
        $userAdmin = new User();
        $userAdmin
            ->setUsername(self::ADMIN_USERNAME)
            ->setPassword(password_hash(self::ADMIN_PASSWORD, PASSWORD_DEFAULT))
            ->setRoles(['ROLE_ADMIN'])
        ;

        $manager->persist($userAdmin);
        $manager->flush();
    }
}
