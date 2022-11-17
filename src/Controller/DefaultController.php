<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController
{
    #[Route('/homepage', name: 'homepage')]
    public function homepage(): Response
    {
        return new Response(
            '<html><body>Appurse clone homepage</body></html>'
        );
    }
}