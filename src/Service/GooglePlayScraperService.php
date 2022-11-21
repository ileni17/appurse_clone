<?php

namespace App\Service;


use App\Entity\App;
use Doctrine\ORM\EntityManagerInterface;
use Nelexa\GPlay\Exception\GooglePlayException;
use Nelexa\GPlay\GPlayApps;
use Symfony\Contracts\Service\Attribute\Required;

class GooglePlayScraperService
{
    #[Required]
    public EntityManagerInterface $entityManager;

    public const DEFAULT_LIMIT = 15;

    /**
     * @throws GooglePlayException
     */
    public function createTopApps(array $googlePlayApps, GPlayApps $playAppsService): void
    {
        foreach ($googlePlayApps as $googleApp) {
            $app = new App();

            $app->setName($googleApp->getName());
            $app->setDescription($googleApp->getDescription());
            $app->setIdentificator($googleApp->getId());
            $app->setAppUrl($googleApp->getUrl());
            $app->setIconUrl((string)$googleApp->getIcon());
            $app->setScore($googleApp->getScore());

            /** Get app category */
            $googleAppCategoryId = $playAppsService->getAppInfo($googleApp->getId())->getCategory()->getId();
            $app->setCategory($this->getReference($googleAppCategoryId));

            $this->entityManager->persist($app);
        }

        $this->entityManager->flush();
    }

    /**
     * @throws GooglePlayException
     */
    public function returnTopApps(): array
    {
        $googlePlayApps = $this->entityManager->getRepository(App::class)->findBy([], [], self::DEFAULT_LIMIT);

        if (!$googlePlayApps) {
            /** Init service */
            $service = new GPlayApps();

            /** Fetch apps */
            $googlePlayApps = $service->getListApps(null, null, self::DEFAULT_LIMIT);

            /** Save apps */
            $this->createTopApps($googlePlayApps, $service);
        }

        return $googlePlayApps;
    }
}
