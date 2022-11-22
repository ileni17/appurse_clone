<?php

declare(strict_types = 1);

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    const ROLE_ADMIN_USERNAME = 'admin';
    const ROLE_ADMIN_PASSWORD = 'admin123';

    const ROLE_USER_USERNAME = 'user';
    const ROLE_USER_PASSWORD = 'user123';

    public function load(ObjectManager $manager)
    {
        $userAdmin = new User();
        $userAdmin
            ->setUsername(self::ROLE_ADMIN_USERNAME)
            ->setPassword(password_hash(self::ROLE_ADMIN_PASSWORD, PASSWORD_DEFAULT))
            ->setRoles(['ROLE_ADMIN'])
        ;

        $manager->persist($userAdmin);

        $userBasic = new User();
        $userBasic
            ->setUsername(self::ROLE_USER_USERNAME)
            ->setPassword(password_hash(self::ROLE_USER_PASSWORD, PASSWORD_DEFAULT))
            ->setRoles(['ROLE_USER'])
        ;

        $manager->persist($userBasic);

        $manager->flush();
    }
}
