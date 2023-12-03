<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Event\SaveWeatherEvent;
use App\Factory\WeatherFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class SaveWeatherSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private WeatherFactory $weatherFactory,
    ) {}

    public static function getSubscribedEvents(): array
    {
        return [
            SaveWeatherEvent::SAVE => 'saveWeather',
        ];
    }

    public function saveWeather(SaveWeatherEvent $event): void
    {
        $weather = $this->weatherFactory->createWithData($event->getCurrentWeatherData());

        $this->entityManager->persist($weather);
        $this->entityManager->flush();
    }
}
