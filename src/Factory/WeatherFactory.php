<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Weather;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class WeatherFactory
{
    public function __construct(
        private DenormalizerInterface $denormalizer,
    ) {}

    /**
     * @param array<string> $currentWeatherData weather data
     */
    public function createWithData(array $currentWeatherData): Weather
    {
        return $this->denormalizer->denormalize($currentWeatherData, Weather::class);
    }
}
