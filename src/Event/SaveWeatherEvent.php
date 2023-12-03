<?php

declare(strict_types=1);

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

class SaveWeatherEvent extends Event
{
    public const SAVE = 'weather.save';

    public function __construct(
        /** @var array<string> $currentWeatherData array of current weather data */
        private array $currentWeatherData,
    ) {}

    /**
     * @return array<string> weather data
     */
    public function getCurrentWeatherData(): array
    {
        return $this->currentWeatherData;
    }
}
