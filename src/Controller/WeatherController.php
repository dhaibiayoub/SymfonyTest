<?php

declare(strict_types=1);

namespace App\Controller;

use App\Provider\WeatherProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeatherController extends AbstractController
{
    #[Route('/weather', name: 'app_weather')]
    public function index(WeatherProvider $weatherProvider): Response
    {
        return $this->render('weather/index.html.twig', [
            'weatherRequests' => $weatherProvider->provideWeatherRequests(),
        ]);
    }
}
