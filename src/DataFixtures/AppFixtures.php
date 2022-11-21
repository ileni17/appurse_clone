<?php

declare(strict_types = 1);

namespace App\DataFixtures;

use App\Entity\App;
use App\Entity\AppCategory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Nelexa\GPlay\Exception\GooglePlayException;
use Nelexa\GPlay\GPlayApps;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @throws GooglePlayException
     */
    public function load(ObjectManager $manager): void
    {
        /** Init service */
        $service = new GPlayApps();

        /** Load apps */
        $googleApps = $service->getListApps(null, null, 15);

        foreach ($googleApps aS $googleApp)
        {
            $app = new App();

            $app->setName($googleApp->getName());
            $app->setDescription($googleApp->getDescription());
            $app->setIdentificator($googleApp->getId());
            $app->setUrl($googleApp->getUrl());
            $app->setIcon((string)$googleApp->getIcon());
            $app->setScore($googleApp->getScore());

            /** Get app category */
            $googleAppCategoryId = $service->getAppInfo($googleApp->getId())->getCategory()->getId();
            $app->setCategory($this->getReference($googleAppCategoryId));

            $manager->persist($app);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            AppCategoryFixtures::class,
        ];
    }

}
