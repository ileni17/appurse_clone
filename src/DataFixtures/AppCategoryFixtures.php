<?php

declare(strict_types = 1);

namespace App\DataFixtures;

use App\Entity\AppCategory;
use Nelexa\GPlay\GPlayApps;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppCategoryFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        /** Init service */
        $service = new GPlayApps();

        /** Load categories */
        $googleCategories = $service->getCategories();

        foreach ($googleCategories AS $googleCategory)
        {
            $category = new AppCategory();

            $category->setName($googleCategory->getName());
            $category->setIdentificator($googleCategory->getId());

            $manager->persist($category);

            $this->addReference($googleCategory->getId(), $category);
        }

        $manager->flush();
    }
}
