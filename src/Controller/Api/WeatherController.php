<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Provider\WeatherProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class WeatherController extends AbstractController
{
    #[Route('/api/weather/{city}', name: 'api_weather')]
    public function index(WeatherProvider $weatherProvider, string $city): JsonResponse
    {
        return $this->json($weatherProvider->provideByCity($city));
    }
}
