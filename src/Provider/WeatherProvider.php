<?php

declare(strict_types=1);

namespace App\Provider;

use App\Client\OpenWeatherClient;
use App\Entity\Weather;
use App\Event\SaveWeatherEvent;
use App\Repository\WeatherRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class WeatherProvider
{
    public function __construct(
        private EventDispatcherInterface $dispatcher,
        private OpenWeatherClient $openWeatherClient,
        private WeatherRepository $weatherRepository,
        private PaginatorInterface $paginator,
        private RequestStack $requestStack,
    ) {}

    /**
     * @return PaginationInterface<Weather>
     */
    public function provideWeatherRequests(): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->weatherRepository->getWeatherRequestsQuery(),
            $this->requestStack->getCurrentRequest()?->query?->getInt('page', 1) ?? 1,
            5
        );
    }

    /**
     * @return array<string> $currentWeatherData weather data
     */
    public function provideByCity(string $city): array
    {
        /** @var array<string> $currentWeatherData weather data */
        $currentWeatherData = $this->openWeatherClient->getCurrentWeatherByCity($city);
        if (false === \array_key_exists('error', $currentWeatherData)) {
            $this->dispatcher->dispatch(new SaveWeatherEvent($currentWeatherData), SaveWeatherEvent::SAVE);
        }

        return $currentWeatherData;
    }
}
