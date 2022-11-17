<?php

declare(strict_types = 1);

namespace App\Controller;

use Nelexa\GPlay\GPlayApps;
use Nelexa\GPlay\Enum\CategoryEnum;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;use Symfony\Component\Routing\Annotation\Route;

class GoogleScraperController extends AbstractController
{
    #[Route('/index', name: 'index')]
    public function index(Request $request) : JsonResponse
    {
        (int) $limit = $request->get('limit', 10);

        $googlePlay = new GPlayApps('hr_HR', 'hr');
        $appInfo = $googlePlay->getAppInfo('com.viber.voip');
        //$appInfo2 = $googlePlay->getAppInfo('io.voodoo.paper2');

        $listApps = $googlePlay->getListApps(CategoryEnum::BEAUTY(), null, $limit);
        /*
        $searchQueryApps = $googlePlay->search('apps', $limit);
        $i = 0;
        foreach ($searchQueryApps AS $app)
        {
            $i++;
        }
        */
        /*
        $listApps = $googlePlay->getListApps('SPORTS', null, $limit);
        $i = 0;
        foreach ($listApps AS $app)
        {
            $i++;
        }
        */
        $topSellingFreeApps = $googlePlay->getTopSellingPaidApps(CategoryEnum::EDUCATION(), $limit);
        $topSellingPaidApps = $googlePlay->getTopSellingPaidApps(CategoryEnum::EDUCATION(), $limit);
        $topGrossingApps = $googlePlay->getTopGrossingApps(CategoryEnum::EDUCATION(), $limit);

        return $this->json($listApps);
    }

    #[Route('/detail/{id}', name: 'detail')]
    public function detail($id, Request $request) : JsonResponse
    {
        $service = new GPlayApps('hr_HR', 'hr');

        return $this->json(
            $service->getAppInfo($id)
        );
    }

    #[Route('/categories', name: 'categories')]
    public function categories(Request $request) : JsonResponse
    {
        $service = new GPlayApps('hr_HR', 'hr');

        return $this->json(
            $service->getCategories()
        );
    }

    #[Route('/top-selling/{type}/{category}', name: 'top_selling')]
    public function topSelling($type, $category, Request $request) : JsonResponse
    {
        (int) $limit = $request->get('limit', 10);

        $service = new GPlayApps('hr_HR', 'hr');

        if ($type == 'free') {
            return $this->json(
                $service->getTopSellingFreeApps(/*CategoryEnum::BEAUTY()*/ $category, $limit)
            );
        }

        if ($type == 'paid') {
            return $this->json(
                $service->getTopSellingPaidApps(/*CategoryEnum::BEAUTY()*/ $category, $limit)
            );
        }

        return $this->json(null);
    }

    #[Route('/top-grossing/{category}', name: 'top_grossing')]
    public function topGrossing($category, Request $request) : JsonResponse
    {
        (int) $limit = $request->get('limit', 10);

        $service = new GPlayApps('hr_HR', 'hr');

        return $this->json(
            $service->getTopGrossingApps($category, $limit)
        );
    }
}