<?php

declare(strict_types=1);

namespace App\Provider;

use App\Client\OpenWeatherClient;
use App\Event\SaveWeatherEvent;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class WeatherProvider
{
    public function __construct(
        private EventDispatcherInterface $dispatcher,
        private OpenWeatherClient $openWeatherClient,
    ) {}

    /**
     * @return array<string> $currentWeatherData weather data
     */
    public function provideByCity(string $city): array
    {
        $currentWeatherData = $this->openWeatherClient->getCurrentWeatherByCity($city);
        if (false === \array_key_exists('error', $currentWeatherData)) {
            $this->dispatcher->dispatch(new SaveWeatherEvent($currentWeatherData), SaveWeatherEvent::SAVE);
        }

        return $currentWeatherData;
    }
}
