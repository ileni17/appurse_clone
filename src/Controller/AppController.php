<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Service\GooglePlayScraperService;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Nelexa\GPlay\Exception\GooglePlayException;
use Nelexa\GPlay\GPlayApps;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    public const DEFAULT_LIMIT = 15;

    /**
     * @throws GooglePlayException
     */
    #[Route('/gp-index', name: 'gp_index')]
    public function index(GooglePlayScraperService $googlePlayScraperService): Response
    {
        return $this->render('app/index.html.twig', [
            'apps' => $googlePlayScraperService->returnTopApps(),
            'title' => 'Google Play Top Apps'
        ]);
    }

    /**
     * @throws GooglePlayException|GuzzleException
     */
    #[Route('/detail/{id}', name: 'app_detail')]
    public function detail(string $id) : Response
    {
        if (is_numeric($id)) {
            $client = new Client(['base_uri' => 'https://itunes.apple.com/lookup?id=' . $id]);
            $response = $client->request('GET', '');

            $details = json_decode($response->getBody()->getContents());
            $details = $details->results[0];

            $client = new Client(['base_uri' => 'https://itunes.apple.com/us/rss/customerreviews/page=1/id=' . $id . '/sortby=mostRecent/json']);
            $response = $client->request('GET', '');

            $reviews = json_decode($response->getBody()->getContents());
            $reviews = $reviews->feed->entry;

            $formattedReviews = [];
            foreach ($reviews as $review) {
                $formattedReviews[] = [
                    'userName' => $review->author->name->label,
                    'text' => $review->content->label
                ];
            }

            $details->reviews = $formattedReviews;
        } else {
            $service = new GPlayApps();
            $details = $service->getAppInfo($id);
        }

        return $this->render('app/details.html.twig', [
            'detail' => $details,
        ]);
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
    #[Route('/gp-top-selling/{category}/category/', name: 'gp_top_selling')]
    public function topSelling(string $category) : Response
    {
        $service = new GPlayApps();

        return $this->render('app/index.html.twig', [
            'apps' => $service->getTopSellingPaidApps($category, self::DEFAULT_LIMIT),
            'title' => 'Google Play Top Selling Apps'
        ]);
    }

    /**
     * @throws GooglePlayException
     */
    #[Route('/gp-top-grossing', name: 'gp_top_grossing')]
    public function topGrossing() : Response
    {
        $service = new GPlayApps();

        return $this->render('app/index.html.twig', [
            'apps' => $service->getTopGrossingApps('APPLICATION', self::DEFAULT_LIMIT),
            'title' => 'Google Play Top Grossing Apps'
        ]);
    }

    /**
     * @throws GuzzleException
     */
    #[Route('/as-top-selling', name: 'as_top_selling')]
    public function appStoreTopGrossing() : Response
    {
        $client = new Client(['base_uri' => 'https://rss.applemarketingtools.com/api/v2/us/apps/top-paid/'. self::DEFAULT_LIMIT .'/apps.json']);
        $response = $client->request('GET','');

        $data = json_decode($response->getBody()->getContents());

        foreach ($data->feed->results as $app) {
            $client = new Client(['base_uri' => 'https://itunes.apple.com/lookup?id=' . $app->id]);
            $response = $client->request('GET', '');

            $details = json_decode($response->getBody()->getContents());

            $app->score = $details->results[0]->averageUserRating;
            $app->description = $details->results[0]->description;
        }

        return $this->render('app/index.html.twig', [
            'apps' => get_object_vars($data->feed)['results'],
            'title' => 'App Store Top Selling Apps'
        ]);
    }
}