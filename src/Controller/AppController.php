<?php

declare(strict_types = 1);

namespace App\Controller;

use Nelexa\GPlay\Exception\GooglePlayException;
use Nelexa\GPlay\GPlayApps;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    const DEFAULT_LIMIT = 10;

    /**
     * @throws GooglePlayException
     */
    #[Route('/index', name: 'app_index')]
    public function index(): Response
    {
        $service = new GPlayApps('hr_HR', 'hr');

        return $this->render('app/index.html.twig', [
            'apps' => $service->getListApps(null, null, self::DEFAULT_LIMIT),
        ]);
    }

    /**
     * @throws GooglePlayException
     */
    #[Route('/detail/{id}', name: 'app_detail')]
    public function detail(string $id) : JsonResponse
    {
        $service = new GPlayApps('hr_HR', 'hr');

        return $this->json(
            $service->getAppInfo($id)
        );
    }

    #[Route('/categories', name: 'app_categories')]
    public function categories(Request $request) : JsonResponse
    {
        $service = new GPlayApps();

        return $this->json(
            $service->getCategories()
        );
    }

    /**
     * @throws GooglePlayException
     */
    #[Route('/top-selling/{category}/category/', name: 'app_top_selling')]
    public function topSelling(string $category) : Response
    {
        $service = new GPlayApps();

        return $this->render('app/index.html.twig', [
            'apps' => $service->getTopSellingPaidApps($category, self::DEFAULT_LIMIT),
        ]);
    }

    /**
     * @throws GooglePlayException
     */
    #[Route('/top-grossing', name: 'app_top_grossing')]
    public function topGrossing() : Response
    {
        $service = new GPlayApps();

        return $this->render('app/index.html.twig', [
            'apps' => $service->getTopGrossingApps('APPLICATION', self::DEFAULT_LIMIT),
        ]);
    }
}